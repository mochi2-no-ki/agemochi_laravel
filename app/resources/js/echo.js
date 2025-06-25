import "./echo_setup.js";

// echo.js または app.js の中
window.Echo.channel("test_channel").listen(".TestMessage", (e) => {
    console.log("📡 受信したイベント:", e);
});
