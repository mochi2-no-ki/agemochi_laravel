<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>公開チャットテスト</title>
  @vite(['resources/js/app.js', 'resources/js/test_public_chat.js'])
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

    #user_id,
    #message_input {
      padding: 0.5rem;
      margin-right: 0.5rem;
    }

    #send_btn {
      padding: 0.5rem 1rem;
    }
  </style>
</head>

<body>
  <h1>公開チャットテスト</h1>

  <div>
    <label for="user_id">あなたの名前:</label>
    <input type="text" id="user_id" placeholder="名前を入力してください">
  </div>

  <div id="chat_box"></div>

  <div>
    <input type="text" id="message_input" placeholder="メッセージを入力">
    <button id="send_btn">送信</button>
  </div>
</body>

</html>
