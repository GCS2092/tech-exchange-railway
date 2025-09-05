import './bootstrap';
import Alpine from 'alpinejs';

// Ajouter jQuery
import $ from 'jquery';
window.$ = window.jQuery = $;

window.Alpine = Alpine;
Alpine.start();

// Désactiver les tentatives de connexion Vite en production
if (typeof window !== 'undefined') {
    // Vérifier si on est en mode développement
    const isDevelopment = import.meta.env.DEV || 
                         window.location.hostname === 'localhost' || 
                         window.location.hostname === '127.0.0.1';
    
    if (!isDevelopment) {
        // Désactiver les tentatives de connexion Vite
        window.__VITE_PROD__ = true;
        console.log('🚀 Mode production - Vite désactivé');
    }
}

// Notification native autorisation
askNotificationPermission();

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

// ✅ Canal commandes (seulement si Echo est configuré)
if (window.Echo && typeof window.Echo.private === 'function') {
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
}
