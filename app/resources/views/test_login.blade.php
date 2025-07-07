<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Test Presence Chat Login</title>
  @vite(['resources/js/app.js', 'resources/js/test_login.js'])
</head>

<body>
  <h1>ログイン</h1>

  <form id="login-form">
    <label for="mail">メールアドレス:</label><br>
    <input type="email" id="mail" name="mail" required><br><br>

    <label for="password">パスワード:</label><br>
    <input type="password" id="password" name="password" required autocomplete="current-password"><br><br>

    <button type="submit">ログイン</button>
  </form>

  <div id="error-message" style="color: red;"></div>

</body>

</html>
