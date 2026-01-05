import { initializeApp } from 'firebase/app';
import { getMessaging, getToken, onMessage } from 'firebase/messaging';

const firebaseConfig = {
    apiKey: "AIzaSyAHRdYjEG3k1JzYR7OW31bLfC71qi0UNCY",
    authDomain: "skywalker-notification.firebaseapp.com",
    projectId: "skywalker-notification",
    storageBucket: "skywalker-notification.firebasestorage.app",
    messagingSenderId: "624087602629",
    appId: "1:624087602629:web:e0bd6c7aaef5ccea2c27ac",
    measurementId: "G-QZWS5CXB81"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const messaging = getMessaging(app);

// Request permission and get token
export async function requestNotificationPermission() {
    try {
        const permission = await Notification.requestPermission();

        if (permission === 'granted') {
            console.log('Notification permission granted.');

            // Register service worker
            const registration = await navigator.serviceWorker.register('/firebase-messaging-sw.js');

            // Wait for service worker to be ready
            await navigator.serviceWorker.ready;

            // Get FCM token - YOU NEED TO ADD YOUR VAPID KEY HERE
            const token = await getToken(messaging, {
                vapidKey: 'YOUR_VAPID_KEY_HERE', // Get this from Firebase Console
                serviceWorkerRegistration: registration
            });

            if (token) {
                console.log('FCM Token:', token);
                return token;
            } else {
                console.log('No registration token available.');
                return null;
            }
        } else {
            console.log('Notification permission denied.');
            return null;
        }
    } catch (error) {
        console.error('Error getting notification permission:', error);
        return null;
    }
}

// Handle foreground messages (when app is open)
export function setupForegroundMessageListener() {
    onMessage(messaging, (payload) => {
        console.log('Message received in foreground:', payload);

        // Show notification even when app is in foreground
        if (Notification.permission === 'granted') {
            const notificationTitle = payload.notification.title || 'New Notification';
            const notificationOptions = {
                body: payload.notification.body || '',
                icon: '/firebase-logo.png',
                data: payload.data || {}
            };

            new Notification(notificationTitle, notificationOptions);
        }
    });
}

// Initialize Firebase messaging
export function initializeFirebaseMessaging() {
    requestNotificationPermission().then(token => {
        if (token) {
            localStorage.setItem('fcm_token', token);
        }
    });

    setupForegroundMessageListener();
}