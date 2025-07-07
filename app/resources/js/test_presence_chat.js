import "./auth_echo_setup";
import axios from "axios";

// axios グローバルヘッダーにもトークンを設定
axios.defaults.headers.common[
    "Authorization"
] = `Bearer ${sessionStorage.getItem("token")}`;

const myMochiId = sessionStorage.getItem("mochi_id");
const memberListElement = document.getElementById("member-list");
const receiverSelectElement = document.getElementById("receiver-select");

// Presence チャンネル参加とメッセージ受信処理
window.Echo.join("test_presence_chat")
    .here((users) => {
        console.log("✅ 参加中ユーザー一覧", users);
        users.forEach(addMember);
    })
    .joining((user) => {
        console.log("➕ ユーザー参加", user);
        addMember(user);
    })
    .leaving((user) => {
        console.log("➖ ユーザー退室", user);
        removeMember(user);
    })
    .listen(".TestPresenceChatMessage", (e) => {
        console.log("📨 全体メッセージ受信", e);
        appendMessage(e);
    })
    .error((err) => {
        console.error("❌ エラー（presenceチャンネル）", err);
    });

// 👇 個人チャネルの購読
window.Echo.private(`test_presence_chat.${myMochiId}`)
    .listen(".TestPresenceChatMessage", (e) => {
        console.log("📩 受信:", e);
        appendMessage(e);
    })
    .error((err) => {
        console.error("❌ チャンネル購読エラー:", err);
    });

// === メンバーの表示処理 ===
function addMember(member) {
    // 宛先選択に追加
    if (
        !document.querySelector(
            `#receiver-select option[value='${member.mochi_id}']`
        )
    ) {
        const option = document.createElement("option");
        option.value = member.mochi_id;
        option.textContent = member.user_name;
        receiverSelectElement.appendChild(option);
    }

    // 参加者リストに追加
    if (
        !document.querySelector(`#member-list li[data-id='${member.mochi_id}']`)
    ) {
        const li = document.createElement("li");
        li.dataset.id = member.mochi_id;
        li.textContent = member.user_name;
        memberListElement.appendChild(li);
    }
}

function removeMember(member) {
    // 宛先選択から削除
    const option = document.querySelector(
        `#receiver-select option[value='${member.mochi_id}']`
    );
    if (option) {
        receiverSelectElement.removeChild(option);
    }

    // 参加者リストから削除
    const li = document.querySelector(
        `#member-list li[data-id='${member.mochi_id}']`
    );
    if (li) {
        memberListElement.removeChild(li);
    }
}

// === 履歴取得 ===
(async () => {
    try {
        const res = await axios.get("/api/auth_socket/chat/presence/log", {
            params: { mochi_id: myMochiId },
        });
        res.data.forEach(appendMessage);
    } catch (error) {
        console.error("履歴取得エラー:", error);
    }
})();

// === 送信処理 ===
document.getElementById("send-button").addEventListener("click", async () => {
    const receiver = document.getElementById("receiver-select").value; // "" = 全体
    const message = document.getElementById("message-input").value;
    const sender = myMochiId;

    if (!message.trim()) return;

    try {
        await axios.post("/api/auth_socket/chat/presence", {
            sender: sender,
            receiver: receiver || null,
            message: message,
        });
        document.getElementById("message-input").value = "";
    } catch (error) {
        console.error("送信エラー:", error);
    }
});

// === 表示処理 ===
function appendMessage({ sender, receiver, message_type, message }) {
    const chatLog = document.getElementById("chat-log");

    const p = document.createElement("p");
    const toPart = message_type === "reply" ? ` → ${receiver}` : "";
    p.textContent = `${sender}${toPart}: ${message}`;
    chatLog.appendChild(p);
}
