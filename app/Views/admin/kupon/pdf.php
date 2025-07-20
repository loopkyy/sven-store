<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Kupon</title>
  <style>
    body { font-family: Arial, sans-serif; font-size: 12px; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { border: 1px solid #000; padding: 6px; text-align: left; }
    th { background-color: #eee; }
    h2 { text-align: center; margin-bottom: 0; }
    .footer { margin-top: 20px; text-align: center; font-size: 10px; color: #555; }
  </style>
</head>
<body>

  <h2>Laporan Data Kupon</h2>

  <table>
    <thead>
      <tr>
        <th>Kode</th>
        <th>Jenis</th>
        <th>Nilai</th>
        <th>Maks. Penggunaan</th>
        <th>Tanggal Berlaku</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($coupons as $c): ?>
      <tr>
        <td><?= esc($c['code']) ?></td>
        <td><?= esc($c['type']) ?></td>
        <td>
          <?= $c['type'] === 'percent' ? $c['value'] . '%' : 'Rp ' . number_format($c['value']) ?>
        </td>
        <td><?= $c['used_count'] ?>/<?= $c['max_uses'] ?></td>
        <td><?= $c['start_date'] ?> s/d <?= $c['end_date'] ?></td>
        <td><?= $c['is_active'] ? 'Aktif' : 'Nonaktif' ?></td>
      </tr>
      <?php endforeach ?>
    </tbody>
  </table>

  <div class="footer">
    Dicetak pada: <?= date('d M Y H:i') ?>
  </div>

</body>
</html>
