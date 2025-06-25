import Echo from "laravel-echo";
import Pusher from "pusher-js";
import axios from "axios";

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

document.addEventListener("DOMContentLoaded", function () {
    const chatBox = document.getElementById("chat_box");
    const userIdInput = document.getElementById("user_id");
    const messageInput = document.getElementById("message_input");
    const sendBtn = document.getElementById("send_btn");

    sendBtn.addEventListener("click", async () => {
        const userId = userIdInput.value.trim();
        const message = messageInput.value.trim();
        if (!userId || !message) return;

        await axios.post("/api/socket/chat/public", {
            user_id: userId,
            message: message,
        });

        messageInput.value = "";
    });

    window.Echo.channel("test_public_chat").listen(
        ".PublicMessageSent",
        (e) => {
            const { user_id, message } = e;
            const msg = `${user_id}: ${message}`;
            const div = document.createElement("div");
            div.textContent = msg;
            chatBox.appendChild(div);
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    );
});
