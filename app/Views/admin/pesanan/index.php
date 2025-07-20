<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('title') ?>Pesanan<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="fw-bold py-3 mb-4">Daftar Pesanan</h4>

<form method="get" class="mb-3">
  <div class="row g-2 align-items-end">
    <div class="col-md-3">
      <label for="status" class="form-label">Filter Status Pesanan</label>
      <select name="status" id="status" class="form-select" onchange="this.form.submit()">
        <option value="">Semua</option>
        <option value="pending" <?= ($filterStatus ?? '') == 'pending' ? 'selected' : '' ?>>Pending</option>
        <option value="paid" <?= ($filterStatus ?? '') == 'paid' ? 'selected' : '' ?>>Paid</option>
        <option value="cancelled" <?= ($filterStatus ?? '') == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
      </select>
    </div>
    <div class="col-md-3">
      <label for="shipping_status" class="form-label">Filter Status Pengiriman</label>
      <select name="shipping_status" id="shipping_status" class="form-select" onchange="this.form.submit()">
        <option value="">Semua</option>
        <option value="belum dikirim" <?= ($filterShipping ?? '') == 'belum dikirim' ? 'selected' : '' ?>>Belum Dikirim</option>
        <option value="dikirim" <?= ($filterShipping ?? '') == 'dikirim' ? 'selected' : '' ?>>Dikirim</option>
        <option value="diterima" <?= ($filterShipping ?? '') == 'diterima' ? 'selected' : '' ?>>Diterima</option>
      </select>
    </div>
  </div>
</form>

<div class="card mt-3">
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
  <tr>
    <th>ID</th>
    <th>Nama Pembeli</th>
    <th>Total</th>
    <th>Status</th>
    <th>Pengiriman</th>
    <th>Metode</th>
    <th>Tanggal</th>
    <th>Aksi</th>
  </tr>
</thead>

     <tbody>
  <?php foreach ($orders as $order): ?>
    <tr>
      <td><?= $order['id'] ?></td>
      <td><?= esc($order['user_name']) ?></td>
      <td>Rp<?= number_format($order['total'], 0, ',', '.') ?></td>
      <td>
        <span class="badge 
          <?= match($order['status']) {
            'paid' => 'bg-success',
            'cancelled' => 'bg-danger',
            default => 'bg-warning text-dark'
          } ?>">
          <?= ucfirst($order['status']) ?>
        </span>
      </td>
      <td>
        <span class="badge
          <?= match($order['shipping_status'] ?? 'belum dikirim') {
            'dikirim' => 'bg-primary',
            'diterima' => 'bg-success',
            default => 'bg-secondary'
          } ?>">
          <?= ucfirst($order['shipping_status'] ?? 'Belum dikirim') ?>
        </span>
      </td>
      <td><?= esc($order['payment_method_name'] ?? '—') ?></td>
      <td><?= date('d M Y H:i', strtotime($order['created_at'])) ?></td>
<td>
  <div class="d-flex gap-2">
    <a href="<?= base_url('admin/pesanan/detail/' . $order['id']) ?>" 
       class="btn btn-info btn-sm" 
       title="Detail">
      <i class="bi bi-eye"></i>
    </a>
    <a href="<?= base_url('admin/pesanan/invoice/' . $order['id']) ?>" 
       class="btn btn-secondary btn-sm" 
       title="Invoice">
      <i class="bi bi-file-earmark-text"></i>
    </a>
  </div>
</td>

    </tr>
  <?php endforeach ?>
</tbody>

    </table>
  </div>
</div>

<?= $this->endSection() ?>
