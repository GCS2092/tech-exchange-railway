const CACHE_NAME = 'pwa-cache-v1';
const urlsToCache = [
  '/', // Page d'accueil
  '/css/styles.css', // Exemple de fichier CSS
  '/js/app.js', // Exemple de fichier JS
  '/images/logo.png' // Exemple d'image
];

// Installation du service worker
self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then((cache) => {
        console.log('📥 Mise en cache des fichiers...');
        return cache.addAll(urlsToCache);
      })
  );
});

// Activation du service worker
self.addEventListener('activate', (event) => {
  const cacheWhitelist = [CACHE_NAME];
  event.waitUntil(
    caches.keys().then((cacheNames) => {
      return Promise.all(
        cacheNames.map((cacheName) => {
          if (!cacheWhitelist.includes(cacheName)) {
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
});

// Récupération des ressources depuis le cache ou le réseau
self.addEventListener('fetch', (event) => {
  event.respondWith(
    caches.match(event.request)
      .then((cachedResponse) => {
        // Si la ressource est dans le cache, la renvoyer, sinon la récupérer depuis le réseau
        return cachedResponse || fetch(event.request);
      })
  );
});
