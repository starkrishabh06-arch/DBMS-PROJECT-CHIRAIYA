<?php
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Oswald:wght@400;600&display=swap");
    *{margin:0;padding:0;box-sizing:border-box;}
    body{background:#060608;display:flex;align-items:center;justify-content:center;height:100vh;font-family:'Oswald',sans-serif;}
    .msg{text-align:center;color:#f5f0e8;}
    .msg h2{font-family:'Bebas Neue',sans-serif;font-size:42px;letter-spacing:4px;color:#c81e1e;margin-bottom:8px;}
    .msg p{font-size:13px;letter-spacing:3px;text-transform:uppercase;color:#9994a0;}
    .dot{display:inline-block;width:8px;height:8px;border-radius:50%;background:#c81e1e;box-shadow:0 0 8px #c81e1e;margin:16px auto 0;animation:pulse 1.4s ease-in-out infinite;}
    @keyframes pulse{0%,100%{opacity:1;transform:scale(1)}50%{opacity:0.4;transform:scale(0.7)}}
  </style>
  <script>
    localStorage.removeItem('access_token');
    localStorage.removeItem('user_data');
    setTimeout(()=>window.location.href='index.php', 1200);
  </script>
</head>
<body>
  <div class="msg">
    <h2>Mission Aborted</h2>
    <p>Logging you out…</p>
    <div class="dot"></div>
  </div>
</body>
</html>
