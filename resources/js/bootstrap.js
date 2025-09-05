import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Créer un objet Echo factice pour éviter les erreurs
window.Echo = {
    private: () => ({
        listen: () => ({ listen: () => {} })
    }),
    channel: () => ({
        listen: () => ({ listen: () => {} })
    })
};

console.log('🚀 Mode production - Echo désactivé');

