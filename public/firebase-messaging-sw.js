// Import Firebase scripts needed for messaging
import { initializeApp } from "https://www.gstatic.com/firebasejs/12.1.0/firebase-app.js";
import { getMessaging, onBackgroundMessage } from "https://www.gstatic.com/firebasejs/12.1.0/firebase-messaging-sw.js";


// Initialize Firebase (use the same config as in your Blade)
const firebaseConfig = {
    apiKey: "AIzaSyC6DEyl86w_6NEtd6Wdtr1y27E1gWgeMNA",
    authDomain: "expences-464117.firebaseapp.com",
    projectId: "expences-464117",
    storageBucket: "expences-464117.firebasestorage.app",
    messagingSenderId: "216195529410",
    appId: "1:216195529410:web:f1b3683e8e0a70f5e5595b",
    measurementId: "G-P1YTSV6EVE"
};

const app = initializeApp(firebaseConfig);
const messaging = getMessaging(app);

// Handle background messages
onBackgroundMessage((payload) => {
    console.log("Background message received: ", payload);

    self.registration.showNotification(payload.notification.title, {
        body: payload.notification.body,
        icon: payload.notification.icon || "/assets/Cazhoo Logo.png",
        data: {
            url: payload.notification.action_url || "https://cazhoo.duodev.in"
        }
    });
});
