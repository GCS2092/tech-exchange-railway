import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import axios from 'axios';

window.Pusher = Pusher;

const isLocal = import.meta.env.DEV;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
    wsHost: isLocal ? window.location.hostname : undefined,
    wsPort: isLocal ? 6001 : undefined,
    wssPort: isLocal ? 6001 : undefined,
    forceTLS: !isLocal,
    encrypted: !isLocal,
    disableStats: true,
    enabledTransports: ['ws', 'wss'],
    authEndpoint: "/broadcasting/auth",
    auth: {
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
        }
    }
});

console.log('✅ Echo initialisé');

// 🔔 Son
function playNotificationSound() {
    const audio = new Audio('/sounds/notification.mp3');
    audio.play().catch(e => console.warn('🔇 Son non joué :', e));
}

// ✅ Éviter superpositions
let notificationTimeout = null;
function showSystemNotification(title, body) {
    if (!("Notification" in window)) return;
    if (notificationTimeout) return;

    if (Notification.permission === "granted") {
        const notification = new Notification(title, {
            body,
            icon: "/images/logo.png",
        });

        notificationTimeout = setTimeout(() => {
            notification.close();
            notificationTimeout = null;
        }, 5000);

        notification.onclick = () => window.focus();
    }
}

// Demande permission
function askNotificationPermission() {
    if ("Notification" in window && Notification.permission !== "granted") {
        Notification.requestPermission().then(permission => {
            console.log('Notification permission :', permission);
        });
    }
}

askNotificationPermission();

// ✅ ADMIN
window.Echo.private('orders')
    .listen('.OrderPlaced', (event) => {
        console.log('📦 Nouvelle commande :', event);
        playNotificationSound();
        showSystemNotification("Nouvelle commande", `Commande #${event.order_id}`);
    });

// ✅ CLIENT
if (window.userId) {
    const channel = `App.Models.User.${window.userId}`;

    window.Echo.private(channel)
        .notification((notification) => {
            console.log('🔔 Notif utilisateur :', notification);

            playNotificationSound();
            showSystemNotification("Notification", notification.message);

            const badge = document.querySelector('.badge-danger');
            if (badge) {
                let count = parseInt(badge.textContent || '0');
                badge.textContent = count + 1;
                badge.style.display = 'inline-block';
            }

            document.dispatchEvent(new CustomEvent('user-notification', { detail: notification }));
        })
        .listen('.OrderStatusUpdated', (event) => {
            console.log('🔄 Statut MAJ :', event.order_id);
            playNotificationSound();
            showSystemNotification("Commande mise à jour", `Commande #${event.order_id} → ${event.status}`);
        });
}

// ✅ WebPush - remplace par ta vraie clé
const vapidPublicKey = import.meta.env.VITE_VAPID_PUBLIC_KEY;

function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding)
        .replace(/\-/g, '+')
        .replace(/_/g, '/');
    const rawData = atob(base64);
    return new Uint8Array([...rawData].map(c => c.charCodeAt(0)));
}
 
