<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>Echo WebSocket Test</title>
  {{-- <script src="http://localhost:6001/socket.io/socket.io.js"></script> --}}
  @vite(['resources/js/app.js']) {{-- Laravel Mix や Vite に応じて --}}
  @vite(['resources/js/echo.js'])
</head>

<body>
  <h1>Echo WebSocket Test</h1>
  <p>ブラウザのコンソールを確認してください。</p>

</body>

</html>
