<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Data Newsletter</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 5px; text-align: left; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h3>Daftar Subscriber Newsletter</h3>
    <table>
        <thead>
            <tr>
                <th>Email</th>
                <th>Status</th>
                <th>Waktu Daftar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($subscribers as $s): ?>
                <tr>
                    <td><?= esc($s['email']) ?></td>
                    <td><?= $s['subscribed'] ? 'Aktif' : 'Tidak Aktif' ?></td>
                    <td><?= $s['created_at'] ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>
</html>
