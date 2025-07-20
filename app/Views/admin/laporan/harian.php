<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('title') ?>Laporan Harian<?= $this->endSection() ?>
<?= $this->section('content') ?>

<h4 class="fw-bold py-3 mb-4">Laporan Penjualan Harian (<?= $tanggal ?>)</h4>

<table class="table">
  <thead>
    <tr>
      <th>ID</th>
      <th>Total</th>
      <th>Status</th>
      <th>Tanggal</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($orders as $order): ?>
    <tr>
      <td><?= $order['id'] ?></td>
      <td>Rp<?= number_format($order['total'], 0, ',', '.') ?></td>
      <td><?= ucfirst($order['status']) ?></td>
      <td><?= $order['created_at'] ?></td>
    </tr>
    <?php endforeach ?>
  </tbody>
</table>

<a href="<?= base_url('admin/laporan') ?>" class="btn btn-secondary mt-3">Kembali</a>

<?= $this->endSection() ?>
