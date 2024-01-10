// service-worker.js

self.addEventListener('install', function(event) {
    event.waitUntil(
      caches.open('your-pwa-cache').then(function(cache) {
        return cache.addAll([
          '/offline.html', // Add URLs to cache for offline support
          // Add other assets to cache (CSS, JS, images, etc.)
        ]);
      })
    );
  });

  self.addEventListener('fetch', function(event) {
    event.respondWith(
      caches.match(event.request).then(function(response) {
        return response || fetch(event.request);
      })
    );
  });
