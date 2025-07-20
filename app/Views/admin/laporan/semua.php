<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('title') ?>Laporan Semua Penjualan<?= $this->endSection() ?>
<?= $this->section('content') ?>

<h4 class="fw-bold py-3 mb-4">📊 Laporan Semua Penjualan</h4>

<?php if (!empty($orders)): ?>
<div class="card">
  <div class="table-responsive">
    <table class="table table-bordered mb-0">
      <thead>
        <tr>
          <th>ID</th>
          <th>Total</th>
          <th>Status</th>
          <th>Tanggal</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $grandTotal = 0;
        foreach ($orders as $order):
          $grandTotal += $order['total'];
        ?>
        <tr>
          <td><?= $order['id'] ?></td>
          <td>Rp<?= number_format($order['total'], 0, ',', '.') ?></td>
          <td>
            <span class="badge <?= match ($order['status']) {
              'paid' => 'bg-success',
              'cancelled' => 'bg-danger',
              default => 'bg-warning text-dark'
            } ?>">
              <?= ucfirst($order['status']) ?>
            </span>
          </td>
          <td><?= date('d M Y H:i', strtotime($order['created_at'])) ?></td>
        </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
</div>

<div class="mt-3 fw-bold">
  Total Penjualan Keseluruhan: Rp<?= number_format($grandTotal, 0, ',', '.') ?>
</div>

<?php else: ?>
<div class="alert alert-info">Tidak ada data penjualan untuk ditampilkan.</div>
<?php endif ?>

<a href="<?= base_url('admin/laporan') ?>" class="btn btn-secondary mt-4">⬅️ Kembali ke Laporan</a>

<?= $this->endSection() ?>
