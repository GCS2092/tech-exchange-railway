import './bootstrap';
import Alpine from 'alpinejs';
import './realtime.js'; 
window.Alpine = Alpine;
Alpine.start();

// Notification native autorisation
askNotificationPermission();

// Import Echo
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
    wsHost: window.location.hostname,
    wsPort: 6001,
    wssPort: 6001,
    disableStats: true,
    encrypted: true,
    authEndpoint: "/broadcasting/auth",
    auth: {
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
        }
    }
});

console.log('✅ Echo initialisé', window.Echo);

// 🔔 Notification son
function playNotificationSound() {
    const audio = new Audio('/sounds/notification.mp3');
    audio.play().catch(e => console.warn('Son non joué :', e));
}

// 🔔 Notification système (bureau)
function showSystemNotification(title, body) {
    if ("Notification" in window && Notification.permission === "granted") {
        const notification = new Notification(title, {
            body,
            icon: '/images/logo.png',
        });

        notification.onclick = () => window.focus();
    }
}

// Demander la permission au chargement
function askNotificationPermission() {
    if ("Notification" in window && Notification.permission !== "granted") {
        Notification.requestPermission().then(permission => {
            console.log('Notification permission :', permission);
        });
    }
}

// ✅ Canal commandes
window.Echo.private('orders')
    .listen('.OrderPlaced', (event) => {
        console.log('📦 Nouvelle commande placée:', event.order);
        playNotificationSound();
        showSystemNotification("Nouvelle commande", `Commande #${event.order.id}`);
    })
    .listen('.OrderStatusUpdated', (event) => {
        console.log('🔄 Statut modifié:', event.order);
        playNotificationSound();
        showSystemNotification("Statut mis à jour", `Commande #${event.order.id} → ${event.order.status}`);
    });

// ✅ Canal utilisateur
if (window.userId) {
    window.Echo.private(`App.Models.User.${window.userId}`)
        .notification((notif) => {
            console.log("🔔 Notification utilisateur :", notif);
            playNotificationSound();
            showSystemNotification("Notification", notif.message);
        });
}
window.Echo.channel('products')
    .listen('.ProductUpdated', (e) => {
        console.log('🛠 Produit mis à jour :', e.product);
        // tu peux ici actualiser la liste de produits sans recharger toute la page
        showSystemNotification("Produit mis à jour", e.product.name + " a été modifié.");
    });
