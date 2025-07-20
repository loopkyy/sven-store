<?= $this->extend('admin/layouts/main') ?> 
<?= $this->section('title') ?>Laporan Penjualan<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="fw-bold py-3 mb-4">Laporan Penjualan</h4>

<form method="get" class="row g-2 mb-3">
  <div class="col-md-3">
    <label>Dari Tanggal</label>
    <input type="date" name="from" class="form-control" value="<?= esc($_GET['from'] ?? '') ?>">
  </div>
  <div class="col-md-3">
    <label>Sampai Tanggal</label>
    <input type="date" name="to" class="form-control" value="<?= esc($_GET['to'] ?? '') ?>">
  </div>
  <div class="col-md-3 d-flex align-items-end">
    <button type="submit" class="btn btn-primary">Filter</button>
  </div>
</form>

<?php $disabled = empty($orders) ? 'disabled' : ''; ?>

<a href="<?= base_url('admin/laporan/export-pdf?from=' . ($_GET['from'] ?? '') . '&to=' . ($_GET['to'] ?? '')) ?>" class="btn btn-danger <?= $disabled ?>">
  🧾 Export PDF
</a>
<a href="<?= base_url('admin/laporan/export-excel?from=' . ($_GET['from'] ?? '') . '&to=' . ($_GET['to'] ?? '')) ?>" class="btn btn-success ms-2 <?= $disabled ?>">
  📥 Export Excel
</a>

<?php if (!empty($chartLabels)): ?>
<canvas id="chartPenjualan" height="100" class="mt-4"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('chartPenjualan');
  const chart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: <?= json_encode($chartLabels) ?>,
      datasets: [{
        label: 'Total Penjualan',
        data: <?= json_encode($chartData) ?>,
        backgroundColor: 'rgba(54, 162, 235, 0.6)',
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
<?php else: ?>
<div class="alert alert-warning mt-3">Tidak ada data grafik untuk tanggal yang dipilih.</div>
<?php endif ?>

<?php if (!empty($orders)): ?>
<div class="card mt-4">
  <div class="table-responsive">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Pembeli</th>
          <th>Status</th>
          <th>Total</th>
          <th>Tanggal</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($orders as $o): ?>
        <tr>
          <td><?= $o['id'] ?></td>
          <td><?= esc($o['user_name']) ?></td>
          <td>
            <span class="badge <?= match($o['status']) {
              'paid' => 'bg-success',
              'cancelled' => 'bg-danger',
              default => 'bg-warning text-dark'
            } ?>">
              <?= ucfirst($o['status']) ?>
            </span>
          </td>
          <td>Rp<?= number_format($o['total'], 0, ',', '.') ?></td>
          <td><?= date('d M Y H:i', strtotime($o['created_at'])) ?></td>
        </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
</div>

<?php
$totalSeluruh = array_sum(array_column($orders, 'total'));
?>
<div class="mt-2 fw-bold">
  Total Penjualan: Rp<?= number_format($totalSeluruh, 0, ',', '.') ?>
</div>

<?php else: ?>
<div class="alert alert-info mt-3">Tidak ada data penjualan untuk ditampilkan.</div>
<?php endif ?>

<div class="list-group mt-4">
  <a href="<?= base_url('admin/laporan/harian') ?>" class="list-group-item list-group-item-action">📅 Laporan Harian</a>
  <a href="<?= base_url('admin/laporan/bulanan') ?>" class="list-group-item list-group-item-action">🗓️ Laporan Bulanan</a>
  <a href="<?= base_url('admin/laporan/semua') ?>" class="list-group-item list-group-item-action">📊 Laporan Keseluruhan</a>
</div>
<?= $this->endSection() ?>
