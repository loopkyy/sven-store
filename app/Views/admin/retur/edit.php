<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('title') ?>Edit Retur<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="fw-bold py-3 mb-4">✏️ Edit Retur</h4>

<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger"><?= session('error') ?></div>
<?php endif ?>

<form action="<?= base_url('admin/retur/update/' . $retur['id']) ?>" method="post">
  <?= csrf_field() ?>
  <div class="card p-4">
    <div class="mb-3">
      <label for="order_id" class="form-label">ID Pesanan</label>
      <input type="text" class="form-control" value="#<?= $retur['order_id'] ?>" readonly>
    </div>

    <div class="mb-3">
      <label for="reason" class="form-label">Alasan Retur</label>
      <textarea name="reason" class="form-control" rows="4" required><?= old('reason', $retur['reason']) ?></textarea>
    </div>

    <div class="mb-3">
      <label for="status" class="form-label">Status</label>
      <select name="status" class="form-select" required>
        <option value="pending" <?= $retur['status'] === 'pending' ? 'selected' : '' ?>>pending</option>
        <option value="approved" <?= $retur['status'] === 'approved' ? 'selected' : '' ?>>approved</option>
        <option value="rejected" <?= $retur['status'] === 'rejected' ? 'selected' : '' ?>>rejected</option>
      </select>
    </div>

    <button type="submit" class="btn btn-success">Update</button>
    <a href="<?= base_url('admin/retur') ?>" class="btn btn-secondary">Kembali</a>
  </div>
</form>
<?= $this->endSection() ?>
