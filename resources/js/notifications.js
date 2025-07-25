// 📁 resources/js/notifications.js
import axios from 'axios';

let lastCheck = null;

function fetchNotifications() {
    axios.get('/notifications?ajax=true')
        .then(response => {
            const notifications = response.data;
            if (notifications.length > 0) {
                notifications.forEach(notif => {
                    showToast(notif.data.message);
                });
                updateBadge(notifications.length);
            }
        })
        .catch(error => console.warn('Erreur lors de la récupération des notifications', error));
}

function updateBadge(count) {
    const badge = document.querySelector('.badge-danger');
    if (badge) {
        badge.textContent = count;
        badge.style.display = count > 0 ? 'inline-block' : 'none';
    }
}

function showToast(message) {
    const div = document.createElement('div');
    div.className = 'fixed bottom-5 right-5 bg-blue-500 text-white px-4 py-2 rounded shadow';
    div.textContent = message;
    document.body.appendChild(div);
    setTimeout(() => div.remove(), 4000);
}

// Démarrer le polling toutes les 10 secondes si connecté
if (window.userId) {
    setInterval(fetchNotifications, 10000);
    fetchNotifications(); // Première exécution immédiate
}
