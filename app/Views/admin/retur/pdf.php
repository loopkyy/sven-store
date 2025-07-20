<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Retur</title>
  <style>
    body {
      font-family: sans-serif;
      font-size: 12px;
      color: #000;
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }
    th, td {
      border: 1px solid #333;
      padding: 6px 8px;
      text-align: left;
    }
    th {
      background-color: #f2f2f2;
    }
    .footer {
      margin-top: 30px;
      text-align: right;
      font-size: 11px;
    }
  </style>
</head>
<body>

  <h2>Laporan Retur Produk</h2>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Pelanggan</th>
        <th>Order ID</th>
        <th>Alasan</th>
        <th>Status</th>
        <th>Waktu</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($returns as $retur): ?>
      <tr>
        <td><?= $retur['id'] ?></td>
        <td><?= esc($retur['username']) ?></td>
        <td>#<?= $retur['order_id'] ?></td>
        <td><?= esc($retur['reason']) ?></td>
        <td><?= ucfirst($retur['status']) ?></td>
        <td><?= date('d M Y H:i', strtotime($retur['created_at'])) ?></td>
      </tr>
      <?php endforeach ?>
    </tbody>
  </table>

  <div class="footer">
    Dicetak pada: <?= date('d M Y H:i') ?>
  </div>

</body>
</html>
