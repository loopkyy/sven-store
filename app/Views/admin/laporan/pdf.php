<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Laporan Penjualan</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 12px;
      color: #333;
    }

    .header {
      text-align: center;
      margin-bottom: 20px;
    }

    .header h2 {
      margin: 0;
      font-size: 18px;
    }

    .header p {
      margin: 2px 0;
      font-size: 12px;
    }

    .periode {
      font-size: 12px;
      margin-top: 5px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
      font-size: 11px;
    }

    table, th, td {
      border: 1px solid #444;
    }

    th {
      background-color: #f2f2f2;
      padding: 6px;
      text-align: center;
    }

    td {
      padding: 6px;
      vertical-align: top;
    }

    .text-right {
      text-align: right;
    }

    .item-table {
      margin-top: 5px;
      margin-bottom: 20px;
    }

    .no-items {
      font-style: italic;
      color: #999;
    }

    .total-summary {
      text-align: right;
      font-weight: bold;
      margin-top: 20px;
    }

    hr {
      margin: 30px 0;
      border: 1px dashed #ccc;
    }
  </style>
</head>
<body>
  <div class="header">
    <h2>Laporan Penjualan</h2>
    <p>E-Commerce Kasir Modern</p>
    <?php if ($from && $to): ?>
      <p class="periode">Periode: <?= date('d-m-Y', strtotime($from)) ?> s/d <?= date('d-m-Y', strtotime($to)) ?></p>
    <?php endif ?>
  </div>

  <?php
    $grandTotal = 0;
  ?>

  <?php if (!empty($orders)): ?>
    <?php foreach ($orders as $order): ?>
      <?php $grandTotal += $order['total']; ?>
      <table>
        <tr>
          <th width="15%">ID</th>
          <td width="35%"><?= $order['id'] ?></td>
          <th width="20%">Tanggal</th>
          <td width="30%"><?= date('d-m-Y H:i', strtotime($order['created_at'])) ?></td>
        </tr>
        <tr>
          <th>Nama User</th>
          <td><?= esc($order['user_name'] ?? '—') ?></td>
          <th>Status</th>
          <td><?= ucfirst($order['status']) ?></td>
        </tr>
        <tr>
          <th>Total</th>
          <td colspan="3"><strong>Rp<?= number_format($order['total'], 0, ',', '.') ?></strong></td>
        </tr>
      </table>

      <table class="item-table">
        <thead>
          <tr>
            <th>Produk</th>
            <th>Harga</th>
            <th>Qty</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($order['items'])): ?>
            <?php foreach ($order['items'] as $item): ?>
              <tr>
                <td><?= esc($item['product_name']) ?></td>
                <td class="text-right">Rp<?= number_format($item['price'], 0, ',', '.') ?></td>
                <td class="text-center"><?= $item['quantity'] ?></td>
                <td class="text-right">Rp<?= number_format($item['subtotal'], 0, ',', '.') ?></td>
              </tr>
            <?php endforeach ?>
          <?php else: ?>
            <tr>
              <td colspan="4" class="no-items">Tidak ada item dalam pesanan ini</td>
            </tr>
          <?php endif ?>
        </tbody>
      </table>
      <hr>
    <?php endforeach ?>

    <div class="total-summary">
      Total Seluruh Penjualan: Rp<?= number_format($grandTotal, 0, ',', '.') ?>
    </div>
  <?php else: ?>
    <p style="text-align: center;">Tidak ada data pesanan.</p>
  <?php endif ?>
</body>
</html>
