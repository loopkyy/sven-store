<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Mingguan</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        td, th { border: 1px solid #ccc; padding: 8px; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Laporan Mingguan</h2>
    <p>Periode: <?= $report->start_date ?> s.d <?= $report->end_date ?></p>

    <table>
        <tr>
            <th>Total Order</th>
            <td><?= $report->total_order ?></td>
        </tr>
        <tr>
            <th>Total Pendapatan</th>
            <td>Rp<?= number_format($report->total_pendapatan, 0, ',', '.') ?></td>
        </tr>
        <tr>
            <th>Pelanggan Baru</th>
            <td><?= $report->pelanggan_baru ?></td>
        </tr>
    </table>

    <h4>Produk Terlaris</h4>
    <table>
        <thead>
            <tr><th>Produk</th><th>Jumlah Terjual</th></tr>
        </thead>
        <tbody>
            <?php foreach ($report->top_products as $p): ?>
                <tr>
                    <td><?= esc($p->name) ?></td>
                    <td><?= $p->total_sold ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>
</html>
