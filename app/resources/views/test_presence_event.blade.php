<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Test Presence Chat</title>
  @vite(['resources/js/app.js', 'resources/js/test_presence_event.js'])
</head>

<body>
  <h1>Test Presence Chat</h1>

  <!-- リアルタイムルーティーンID入力 -->
  <label for="realtime-routine-id-input">リアルタイムルーティーンID：</label>
  <input type="text" id="realtime-routine-id-input" placeholder="リアルタイムルーティーンIDを入力">
  <button id="connect-button">接続</button>

  <!-- 現在の接続中のルーティーンID表示 -->
  <div style="margin-top: 10px;">
    <strong>現在のリアルタイムルーティーンID：</strong>
    <span id="current-realtime-routine-id">未接続</span>
  </div>

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
