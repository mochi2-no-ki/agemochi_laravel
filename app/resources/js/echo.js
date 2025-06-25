import Echo from "laravel-echo";

import Pusher from "pusher-js";
window.Pusher = Pusher;
window.Pusher.logToConsole = true;

window.Echo = new Echo({
    broadcaster: "reverb",
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? "https") === "https",
    enabledTransports: ["ws", "wss"],
});

// echo.js または app.js の中
window.Echo.channel("test_channel").listen(".TestMessage", (e) => {
    console.log("📡 受信したイベント:", e);
});
