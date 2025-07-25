import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    wsHost: window.location.hostname,   // 👈 Host local (localhost ou 127.0.0.1)
    wsPort: 6001,
    wssPort: 6001,
    forceTLS: false,                    // 👈 Pas de HTTPS
    encrypted: false,                  // 👈 WebSocket non chiffré
    disableStats: true,
    enabledTransports: ['ws', 'wss'],
    authEndpoint: "/broadcasting/auth",
    auth: {
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
        }
    }
});

// ✅ Écoute globale des événements de commande (canal privé partagé 'orders')
window.Echo.private('orders')
    .listen('.OrderPlaced', (event) => {
        console.log('📦 Nouvelle commande passée:', event);
        if (window.toastr) {
            toastr.success(`Nouvelle commande #${event.order_id} - Total: ${event.total} €`);
        }
    })
    .listen('.OrderStatusUpdated', (event) => {
        console.log('🛠 Statut de commande mis à jour:', event);
        if (window.toastr) {
            toastr.info(`Commande #${event.order_id} → ${event.status}`);
        }

        // Événement JS personnalisé (si tu veux capter ça côté Vue ou Blade)
        document.dispatchEvent(new CustomEvent('order-status-updated', { detail: event }));
    });

// ✅ Notifications privées pour l'utilisateur connecté
if (window.userId) {
    window.Echo.private(`App.Models.User.${window.userId}`)
        .notification((notification) => {
            console.log('🔔 Notification reçue:', notification);

            if (window.toastr) {
                toastr.info(notification.message || 'Vous avez une nouvelle notification.');
            }

            const badge = document.querySelector('.badge-danger');
            if (badge) {
                let count = parseInt(badge.textContent || '0');
                badge.textContent = count + 1;
                badge.style.display = 'inline-block';
            }

            document.dispatchEvent(new CustomEvent('user-notification', { detail: notification }));
        });
}
