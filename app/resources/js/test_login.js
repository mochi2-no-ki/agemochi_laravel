import axios from "axios";

// 明示的に baseURL を設定（ルートからの絶対パスで解決）
axios.defaults.baseURL = "/";

document.getElementById("login-form").addEventListener("submit", async (e) => {
    e.preventDefault();

    const mail = document.getElementById("mail").value;
    const password = document.getElementById("password").value;
    const errorMessage = document.getElementById("error-message");

    try {
        const response = await axios.post("/api/login", {
            mail,
            password,
        });

        const { token, mochi_id, user_name, user_id } = response.data;

        // トークンとユーザー情報を sessionStorage に保存
        sessionStorage.setItem("token", token);
        sessionStorage.setItem("mochi_id", mochi_id);
        sessionStorage.setItem("user_name", user_name);
        sessionStorage.setItem("user_id", user_id);

        // チャット画面に遷移
        window.location.href = "/web/test_presence_chat";
    } catch (error) {
        console.error("Login failed:", error);
        errorMessage.textContent =
            "ログインに失敗しました。メールアドレスまたはパスワードを確認してください。";
    }
});
