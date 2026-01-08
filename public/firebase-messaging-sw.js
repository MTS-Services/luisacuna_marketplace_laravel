// public/firebase-messaging-sw.js
// This file handles background notifications when the browser/app is not in focus

importScripts('https://www.gstatic.com/firebasejs/10.7.1/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.7.1/firebase-messaging-compat.js');

// Firebase configuration - Replace with your actual config
firebase.initializeApp({
    apiKey: "YOUR_API_KEY",
    authDomain: "YOUR_AUTH_DOMAIN",
    projectId: "YOUR_PROJECT_ID",
    storageBucket: "YOUR_STORAGE_BUCKET",
    messagingSenderId: "YOUR_MESSAGING_SENDER_ID",
    appId: "YOUR_APP_ID"
});

const messaging = firebase.messaging();

// Handle background messages
messaging.onBackgroundMessage((payload) => {
    console.log('[firebase-messaging-sw.js] Received background message:', payload);

    const notificationTitle = payload.notification?.title || 'Notification';
    const notificationOptions = {
        body: payload.notification?.body || '',
        icon: '/assets/images/logo.png',
        badge: '/assets/images/badge.png',
        data: payload.data || {},
        requireInteraction: payload.data?.type === 'force_logout' // Keep notification visible for logout
    };

    // Check if it's a force logout notification
    if (payload.data && payload.data.type === 'force_logout') {
        // Clear all caches
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cacheName) => {
                    return caches.delete(cacheName);
                })
            );
        });

        // Notify all clients to logout
        self.clients.matchAll().then((clients) => {
            clients.forEach((client) => {
                client.postMessage({
                    type: 'force_logout',
                    message: payload.notification?.body || 'You have been logged out.',
                    timestamp: new Date().toISOString()
                });
            });
        });

        // Show notification
        return self.registration.showNotification(notificationTitle, {
            ...notificationOptions,
            actions: [
                { action: 'login', title: 'Login Again' }
            ]
        });
    }

    // Show regular notification
    return self.registration.showNotification(notificationTitle, notificationOptions);
});

// Handle notification click
self.addEventListener('notificationclick', (event) => {
    console.log('[firebase-messaging-sw.js] Notification click received.');

    event.notification.close();

    const urlToOpen = event.action === 'login'
        ? new URL('/login', self.location.origin).href
        : new URL('/', self.location.origin).href;

    // Open the URL
    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true })
            .then((windowClients) => {
                // Check if there's already a window open
                for (let i = 0; i < windowClients.length; i++) {
                    const client = windowClients[i];
                    if (client.url === urlToOpen && 'focus' in client) {
                        return client.focus();
                    }
                }
                // If not, open a new window
                if (clients.openWindow) {
                    return clients.openWindow(urlToOpen);
                }
            })
    );
});

// Handle service worker activation
self.addEventListener('activate', (event) => {
    console.log('[firebase-messaging-sw.js] Service Worker activated');
});

// Handle service worker installation
self.addEventListener('install', (event) => {
    console.log('[firebase-messaging-sw.js] Service Worker installed');
    self.skipWaiting();
});