<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Promo dari Lunaya</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      color: #333;
      background-color: #f4f4f4;
      padding: 20px;
    }
    .container {
      max-width: 600px;
      margin: auto;
      background: #fff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }
    .header {
      text-align: center;
      margin-bottom: 20px;
    }
    .header h2 {
      color: #5c6bc0;
    }
    .footer {
      margin-top: 30px;
      font-size: 13px;
      color: #888;
      text-align: center;
    }
    .promo-button {
      display: inline-block;
      margin-top: 20px;
      padding: 12px 24px;
      background-color: #5c6bc0;
      color: white;
      text-decoration: none;
      border-radius: 5px;
    }
    .promo-button:hover {
      background-color: #3f51b5;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h2>Promo Spesial dari Lunaya 💜</h2>
    </div>
    
    <div class="message">
      <?= $message ?>
    </div>

    <div style="text-align:center;">
      <a href="http://ecommerce.test/" class="promo-button">Kunjungi Toko</a>
    </div>

    <div class="footer">
      Anda menerima email ini karena berlangganan di Lunaya.<br>
      Jika Anda tidak ingin menerima email lagi, abaikan email ini.
    </div>
  </div>
</body>
</html>
