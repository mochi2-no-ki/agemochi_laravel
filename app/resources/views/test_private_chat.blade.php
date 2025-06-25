<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>個人チャットテスト</title>
  @vite(['resources/js/app.js', 'resources/js/test_private_chat.js'])
  <style>
    body {
      font-family: sans-serif;
      margin: 2rem;
    }

    #chat_box {
      border: 1px solid #ccc;
      padding: 1rem;
      height: 300px;
      overflow-y: scroll;
      margin-bottom: 1rem;
    }

    input {
      padding: 0.5rem;
      margin-right: 0.5rem;
    }

    #send_btn,
    #register_btn {
      padding: 0.5rem 1rem;
    }
  </style>
</head>

<body>
  <h1>個人チャットテスト</h1>

  <div>
    <label for="user_id">あなたのID:</label>
    <input type="text" id="user_id" placeholder="例: userA">
    <button id="register_btn">登録</button>
  </div>

  <div>
    <label for="target_id">送信先のID (空欄で全体送信):</label>
    <input type="text" id="target_id" placeholder="例: userB">
  </div>

  <div id="chat_box"></div>

  <div>
    <input type="text" id="message_input" placeholder="メッセージを入力">
    <button id="send_btn">送信</button>
  </div>
</body>

</html>
