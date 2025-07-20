<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Invoice #<?= $order['id'] ?></title>
  <style>
    body { font-family: Arial, sans-serif; font-size: 12px; }
    h2 { text-align: center; }
    .info { margin-bottom: 20px; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { border: 1px solid #000; padding: 6px; text-align: left; }
    .text-end { text-align: right; }
  </style>
</head>
<body>
  <h2>Invoice #<?= $order['id'] ?></h2>

  <div class="info">
    <p><strong>Nama Pelanggan:</strong> <?= esc($order['user_name'] ?? $order['username'] ?? '–') ?>

    <p><strong>Metode Pembayaran:</strong> <?= esc($order['payment_method_name'] ?? '–') ?></p>
    <p><strong>Status:</strong> <?= ucfirst($order['status']) ?></p>
    <p><strong>Tanggal:</strong> <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></p>
  </div>

  <table>
    <thead>
      <tr>
        <th>Produk</th>
        <th>Harga</th>
        <th>Qty</th>
        <th>Subtotal</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($items as $item): ?>
      <tr>
        <td><?= esc($item['product_name']) ?></td>
        <td class="text-end">Rp<?= number_format($item['price'], 0, ',', '.') ?></td>
        <td><?= $item['quantity'] ?></td>
        <td class="text-end">Rp<?= number_format($item['subtotal'], 0, ',', '.') ?></td>
      </tr>
      <?php endforeach ?>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="3" class="text-end">Total</th>
        <th class="text-end">Rp<?= number_format($order['total'], 0, ',', '.') ?></th>
      </tr>
    </tfoot>
  </table>
</body>
</html>
