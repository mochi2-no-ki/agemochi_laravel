import axios from "axios";
import "./echo_setup.js";

document.addEventListener("DOMContentLoaded", () => {
    let myId = null;
    let subscribed = false;

    // ID登録ボタン処理
    const registerBtn = document.getElementById("register_btn");
    registerBtn.addEventListener("click", () => {
        const inputId = document.getElementById("user_id").value.trim();
        if (inputId === "") {
            alert("IDを入力してください。");
            return;
        }
        myId = inputId;
        alert(`あなたのIDを '${myId}' に設定しました。`);

        if (!subscribed) {
            // ✅ 個人宛チャンネル購読
            window.Echo.channel(`test_private_chat.${myId}`).listen(
                ".TestPrivateChat",
                (e) => {
                    const chatBox = document.getElementById("chat_box");
                    const msg = `[${e.from} → ${e.to}]: ${e.message}`;
                    chatBox.innerHTML += `<div>${msg}</div>`;
                    chatBox.scrollTop = chatBox.scrollHeight;
                }
            );

            // ✅ 全体宛チャンネル購読（全体メッセージ受信用）
            window.Echo.channel("test_private_chat").listen(
                ".TestPrivateChat",
                (e) => {
                    const chatBox = document.getElementById("chat_box");
                    const msg = `[${e.from} → 全体]: ${e.message}`;
                    chatBox.innerHTML += `<div>${msg}</div>`;
                    chatBox.scrollTop = chatBox.scrollHeight;
                }
            );

            // 将来的に PrivateChannel を使う場合（Laravel認証が必要）
            // window.Echo.private(`test_private_chat.${myId}`)
            //     .listen(".TestPrivateChat", (e) => { ... });

            subscribed = true;
        }
    });

    // メッセージ送信ボタン処理
    const sendBtn = document.getElementById("send_btn");
    sendBtn.addEventListener("click", async () => {
        if (!myId) {
            alert("まずあなたのIDを登録してください。");
            return;
        }

        const targetId = document.getElementById("target_id").value.trim();
        const message = document.getElementById("message_input").value.trim();

        if (message === "") return;

        try {
            await axios.post("/api/socket/chat/private", {
                from: myId,
                to: targetId || null,
                message: message,
            });
            document.getElementById("message_input").value = "";
        } catch (error) {
            console.error("送信エラー:", error);
        }
    });
});
