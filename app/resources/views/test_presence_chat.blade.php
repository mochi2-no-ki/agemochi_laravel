<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Test Presence Chat</title>
  @vite(['resources/js/app.js', 'resources/js/test_presence_chat.js'])
</head>

<body>
  <h1>Test Presence Chat</h1>

  <!-- 宛先選択 -->
  <label for="receiver-select">送信先：</label>
  <select id="receiver-select">
    <option value="">全体送信</option>
  </select>

  <!-- メッセージ入力 -->
  <input type="text" id="message-input" placeholder="メッセージを入力">
  <button id="send-button">送信</button>

  <!-- チャットログ表示 -->
  <div style="margin-top: 20px;">
    <h2>チャットログ</h2>
    <div id="chat-log"></div>
  </div>

  <!-- 参加者一覧表示 -->
  <div style="margin-top: 20px;">
    <h2>現在の参加者</h2>
    <ul id="member-list" style="list-style: disc; padding-left: 20px;"></ul>
  </div>
</body>

</html>
