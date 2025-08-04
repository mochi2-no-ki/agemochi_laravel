import "./auth_echo_setup";
import axios from "axios";

// ログイン済みかチェック（トークンまたは mochi_id 不存在ならリダイレクト）
if (!sessionStorage.getItem("token") || !sessionStorage.getItem("mochi_id")) {
    window.location.href = "/web/test_presence_event_login";
}

// axios グローバルヘッダーにもトークンを設定
axios.defaults.headers.common[
    "Authorization"
] = `Bearer ${sessionStorage.getItem("token")}`;

const myMochiId = sessionStorage.getItem("mochi_id");
const memberListElement = document.getElementById("member-list");
const receiverSelectElement = document.getElementById("receiver-select");
const connectButton = document.getElementById("connect-button");
const sendButton = document.getElementById("send-button");
const currentRealtimeRoutineIdSpan = document.getElementById(
    "current-realtime-routine-id"
);

// 初期状態では送信ボタンを無効化
sendButton.disabled = true;

let currentRealtimeRoutineId = null;
const presenceChannel = `presence_realtime_routine`;
const privateChannel = `private_realtime_routine`;

// === 接続処理 ===
connectButton.addEventListener("click", () => {
    // ボタンを一時的に無効化
    connectButton.disabled = true;
    sendButton.disabled = true;

    // すでに接続中ならチャンネルから離脱
    if (currentRealtimeRoutineId) {
        const oldPresenceChannelId = `${presenceChannel}.${currentRealtimeRoutineId}`;
        const oldPrivateChannelId = `${privateChannel}.${currentRealtimeRoutineId}.${myMochiId}`;
        window.Echo.leave(oldPresenceChannelId);
        window.Echo.leave(oldPrivateChannelId);
        currentRealtimeRoutineId = null;
        currentRealtimeRoutineIdSpan.textContent = "未接続";
        memberListElement.innerHTML = "";
        receiverSelectElement.innerHTML = "<option value=''>全体送信</option>";
        document.getElementById("chat-log").innerHTML = "";
    }

    const inputRealtimeRoutineId = document
        .getElementById("realtime-routine-id-input")
        .value.trim();
    if (!inputRealtimeRoutineId) {
        currentRealtimeRoutineIdSpan.textContent = "未接続";
        connectButton.disabled = false;
        return;
    }

    const presenceChannelId = `${presenceChannel}.${inputRealtimeRoutineId}`;
    const priveteChannelId = `${privateChannel}.${inputRealtimeRoutineId}`;
    currentRealtimeRoutineId = inputRealtimeRoutineId;
    currentRealtimeRoutineIdSpan.textContent = inputRealtimeRoutineId;

    // 各処理の完了状態
    let presenceReady = false;
    let privateReady = false;
    let historyReady = false;

    function tryEnableConnectButton() {
        console.log("現在の状態:", {
            presenceReady,
            privateReady,
            historyReady,
        });

        if (presenceReady && privateReady && historyReady) {
            connectButton.disabled = false;
            sendButton.disabled = false;
        }
    }

    // Presence チャンネル参加とメッセージ受信処理
    window.Echo.join(presenceChannelId)
        .here((users) => {
            console.log("✅ 参加中ユーザー一覧", users);
            users.forEach(addMember);
            presenceReady = true;
            tryEnableConnectButton();
        })
        .joining((user) => {
            console.log("➕ ユーザー参加", user);
            addMember(user);
        })
        .leaving((user) => {
            console.log("➖ ユーザー退室", user);
            removeMember(user);
        })
        .listen(".realtime_routine.started", () => {
            appendMessage({
                sender: "サーバー通知",
                receiver: "全員",
                message_type: "announce",
                message: "リアルタイムルーティーンが開始されました",
            });
        })
        .listen(".realtime_routine.ended", () => {
            console.log("リアルタイムルーティーンが終了");
            appendMessage({
                sender: "サーバー通知",
                receiver: "全員",
                message_type: "announce",
                message: "リアルタイムルーティーンが終了しました",
            });
        })
        .listen(".realtime_routine.closed", () => {
            console.log("リアルタイムルーティーンが閉会");
            appendMessage({
                sender: "サーバー通知",
                receiver: "全員",
                message_type: "announce",
                message:
                    "リアルタイムルーティーンが閉会しました（チャンネルを離脱します）",
            });
            if (currentRealtimeRoutineId) {
                window.Echo.leave(presenceChannelId);
                window.Echo.leave(`${priveteChannelId}.${myMochiId}`);
                currentRealtimeRoutineId = null;
                currentRealtimeRoutineIdSpan.textContent = "未接続";
                memberListElement.innerHTML = "";
                receiverSelectElement.innerHTML =
                    "<option value=''>全体送信</option>";
            }
        })
        .listen(".realtime_routine.message", (e) => {
            console.log("📨 全体メッセージ受信", e);
            appendMessage(e);
        })
        .error((err) => {
            console.error("❌ エラー（presenceチャンネル）", err);
            currentRealtimeRoutineIdSpan.textContent = "未接続";
            presenceReady = true;
            tryEnableConnectButton();
        });

    // 個人チャンネルの購読
    window.Echo.private(`${priveteChannelId}.${myMochiId}`)
        .subscribed(() => {
            privateReady = true;
            tryEnableConnectButton();
        })
        .listen(".realtime_routine.message", (e) => {
            console.log("📩 受信:", e);
            appendMessage(e);
        })
        .error((err) => {
            console.error("❌ チャンネル購読エラー:", err);
            currentRealtimeRoutineIdSpan.textContent = "未接続";
            privateReady = true;
            tryEnableConnectButton();
        });

    // === 履歴取得 ===
    (async () => {
        try {
            document.getElementById("chat-log").innerHTML = "";

            const res = await axios.get(
                "/api/auth_socket/chat/test_presence_event/log",
                {
                    params: {
                        mochi_id: myMochiId,
                        realtime_routine_id: currentRealtimeRoutineId,
                    },
                }
            );
            res.data.forEach(appendMessage);
        } catch (error) {
            console.error("履歴取得エラー:", error);
            currentRealtimeRoutineIdSpan.textContent = "未接続";
        } finally {
            historyReady = true;
            tryEnableConnectButton();
        }
    })();
});

// === メンバーの表示処理 ===
function addMember(member) {
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
    const option = document.querySelector(
        `#receiver-select option[value='${member.mochi_id}']`
    );
    if (option) receiverSelectElement.removeChild(option);

    const li = document.querySelector(
        `#member-list li[data-id='${member.mochi_id}']`
    );
    if (li) memberListElement.removeChild(li);
}

// === 送信処理 ===
document.getElementById("send-button").addEventListener("click", async () => {
    const receiver = document.getElementById("receiver-select").value;
    const message = document.getElementById("message-input").value;
    const sender = myMochiId;

    if (!message.trim()) return;

    sendButton.disabled = true;
    try {
        await axios.post("/api/auth_socket/chat/test_presence_event", {
            sender: sender,
            receiver: receiver || null,
            message: message,
            realtime_routine_id: currentRealtimeRoutineId,
        });
        document.getElementById("message-input").value = "";
    } catch (error) {
        console.error("送信エラー:", error);
    } finally {
        sendButton.disabled = false;
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
