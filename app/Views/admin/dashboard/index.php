<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h4 class="fw-bold py-3 mb-4">Dashboard</h4>

<!-- Filter Tanggal -->
<section class="mb-4">
  <form method="get" class="row g-3">
    <div class="col-md-3">
      <label for="start_date" class="form-label">Dari Tanggal</label>
      <input type="date" name="start_date" class="form-control" value="<?= esc($startDate) ?>">
    </div>
    <div class="col-md-3">
      <label for="end_date" class="form-label">Sampai Tanggal</label>
      <input type="date" name="end_date" class="form-control" value="<?= esc($endDate) ?>">
    </div>
    <div class="col-md-2 d-flex align-items-end">
      <button type="submit" class="btn btn-primary w-100">Filter</button>
    </div>
  </form>
</section>

<!-- Notifikasi -->
<section>
  <?php if (!empty($lowStockProducts)): ?>
    <div class="alert alert-warning">
      <strong>⚠ Produk Hampir Habis!</strong>
      <ul class="mb-0">
        <?php foreach ($lowStockProducts as $produk): ?>
          <li><?= esc($produk['name']) ?> — Stok: <strong><?= $produk['stock'] ?></strong></li>
        <?php endforeach ?>
      </ul>
    </div>
  <?php endif ?>

  <?php if (!empty($belumDikirim)): ?>
    <div class="alert alert-info">
      🚚 <strong><?= $belumDikirim ?></strong> pesanan belum dikirim!
    </div>
  <?php endif ?>
</section>

<!-- Statistik -->
<section class="row">
  <!-- Total Produk -->
  <div class="col-lg-3 col-md-6 mb-4">
    <div class="card h-100 text-center">
      <div class="card-body">
        <h5 class="card-title">Total Produk</h5>
        <p class="display-6"><?= $totalProduk ?></p>
      </div>
    </div>
  </div>

  <!-- Total Order -->
  <div class="col-lg-3 col-md-6 mb-4">
    <div class="card h-100 text-center">
      <div class="card-body">
        <h5 class="card-title">Total Order</h5>
        <p class="display-6"><?= $totalOrder ?></p>
        <?php if ($trenOrder === 'up'): ?>
          <span class="badge bg-success">🔼 Naik dari minggu lalu</span>
        <?php elseif ($trenOrder === 'down'): ?>
          <span class="badge bg-danger">🔽 Turun dari minggu lalu</span>
        <?php else: ?>
          <span class="badge bg-secondary">➖ Stabil</span>
        <?php endif ?>
        <small class="d-block text-muted mt-1">Minggu lalu: <?= $orderMingguLalu ?></small>
      </div>
    </div>
  </div>

  <!-- Pendapatan -->
  <div class="col-lg-3 col-md-6 mb-4">
    <div class="card h-100 text-center">
      <div class="card-body">
        <h5 class="card-title">Pendapatan</h5>
        <p class="display-6">Rp<?= number_format($totalPendapatan, 0, ',', '.') ?></p>
        <?php if ($trenPendapatan === 'up'): ?>
          <span class="badge bg-success">🔼 Naik dari minggu lalu</span>
        <?php elseif ($trenPendapatan === 'down'): ?>
          <span class="badge bg-danger">🔽 Turun dari minggu lalu</span>
        <?php else: ?>
          <span class="badge bg-secondary">➖ Stabil</span>
        <?php endif ?>
        <small class="d-block text-muted mt-1">Minggu lalu: Rp<?= number_format($pendapatanMingguLalu, 0, ',', '.') ?></small>
      </div>
    </div>
  </div>

  <!-- Pelanggan Aktif -->
  <div class="col-lg-3 col-md-6 mb-4">
    <div class="card h-100 text-center">
      <div class="card-body">
        <h5 class="card-title">Pelanggan Aktif</h5>
        <p class="display-6"><?= $totalPelangganAktif ?></p>
      </div>
    </div>
  </div>

  <!-- Pelanggan Baru -->
  <div class="col-lg-3 col-md-6 mb-4">
    <div class="card h-100 text-center">
      <div class="card-body">
        <h5 class="card-title">Pelanggan Baru</h5>
        <p class="display-6"><?= $pelangganBaruMingguIni ?></p>
        <?php if ($trenPelanggan === 'up'): ?>
          <span class="badge bg-success">🔼 Naik dari minggu lalu</span>
        <?php elseif ($trenPelanggan === 'down'): ?>
          <span class="badge bg-danger">🔽 Turun dari minggu lalu</span>
        <?php else: ?>
          <span class="badge bg-secondary">➖ Stabil</span>
        <?php endif ?>
        <small class="d-block text-muted mt-1">Minggu lalu: <?= $pelangganBaruMingguLalu ?> pelanggan</small>
      </div>
    </div>
  </div>
</section>

<!-- Produk Terlaris -->
<section class="card mb-4">
  <div class="card-body">
    <h5 class="card-title">Produk Terlaris</h5>
    <?php if (!empty($topProducts)): ?>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Produk</th>
              <th>Total Terjual</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($topProducts as $row): ?>
              <tr>
                <td><?= esc($row->name) ?></td>
                <td><?= esc($row->total_sold) ?></td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <p class="text-muted">Belum ada data penjualan.</p>
    <?php endif ?>
  </div>
</section>

<!-- Grafik Penjualan -->
<section class="card mb-4">
  <div class="card-body">
    <h5 class="card-title">Grafik Penjualan (7 Hari Terakhir)</h5>
    <canvas id="salesChart" height="100"></canvas>
  </div>
</section>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('salesChart').getContext('2d');
  const salesChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: <?= json_encode(array_column($grafikPenjualan, 'tanggal')) ?>,
      datasets: [{
        label: 'Total Penjualan',
        data: <?= json_encode(array_map(fn($d) => (int)$d->total, $grafikPenjualan)) ?>,
        fill: true,
        borderColor: '#3b82f6',
        backgroundColor: 'rgba(59, 130, 246, 0.2)',
        tension: 0.3
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            callback: function(value) {
              return 'Rp' + value.toLocaleString('id-ID');
            }
          }
        }
      }
    }
  });
</script>

<?= $this->endSection() ?>
