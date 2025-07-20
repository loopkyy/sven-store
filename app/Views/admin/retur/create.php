<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('title') ?>Pengajuan Retur<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="fw-bold py-3 mb-4">📝 Pengajuan Retur</h4>

<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif ?>

<form action="<?= base_url('admin/retur/store') ?>" method="post">
  <?= csrf_field() ?>
  <div class="card p-4">
    <div class="mb-3">
      <label for="order_id" class="form-label">Pilih Pesanan</label>
      <select name="order_id" class="form-select" required>
        <option value="">-- Pilih Pesanan --</option>
        <?php foreach ($orders as $order): ?>
          <option value="<?= $order['id'] ?>" <?= old('order_id') == $order['id'] ? 'selected' : '' ?>>
            #<?= $order['id'] ?> - <?= $order['created_at'] ?>
          </option>
        <?php endforeach ?>
      </select>
    </div>

    <div class="mb-3">
      <label for="reason" class="form-label">Alasan Retur</label>
      <textarea name="reason" class="form-control" rows="4" required><?= old('reason') ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Kirim Retur</button>
    <a href="<?= base_url('admin/retur') ?>" class="btn btn-secondary">Batal</a>
  </div>
</form>
<?= $this->endSection() ?>
