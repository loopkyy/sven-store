<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('title') ?>Edit Metode Pembayaran<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="fw-bold py-3 mb-4">Edit Metode Pembayaran</h4>
<?php if (session('errors')): ?>
  <div class="alert alert-danger">
    <ul class="mb-0">
      <?php foreach (session('errors') as $error): ?>
        <li><?= esc($error) ?></li>
      <?php endforeach ?>
    </ul>
  </div>
<?php endif ?>

<form action="<?= base_url('admin/pembayaran/update/' . $method['id']) ?>" method="post">
  <?= csrf_field() ?>
  <div class="card p-4">
    <div class="mb-3">
      <label for="name" class="form-label">Nama Metode</label>
      <input type="text" name="name" class="form-control" value="<?= esc($method['name']) ?>" required>
    </div>

    <div class="mb-3">
      <label for="type" class="form-label">Jenis</label>
      <select name="type" class="form-select" required>
        <option value="">-- Pilih Jenis --</option>
        <option value="cod" <?= $method['type'] === 'cod' ? 'selected' : '' ?>>COD</option>
        <option value="bank_transfer" <?= $method['type'] === 'bank_transfer' ? 'selected' : '' ?>>Transfer Bank</option>
        <option value="qris" <?= $method['type'] === 'qris' ? 'selected' : '' ?>>QRIS</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="details" class="form-label">Detail</label>
     <textarea name="details" class="form-control" rows="3" placeholder="Contoh: No Rekening / Link QRIS"><?= esc($method['details']) ?></textarea>

    </div>

    <div class="form-check form-switch mb-3">
      <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?= $method['is_active'] ? 'checked' : '' ?>>
<label class="form-check-label" for="is_active">Aktifkan Metode</label>

    </div>

    <button type="submit" class="btn btn-primary">Perbarui</button>
    <a href="<?= base_url('admin/pembayaran') ?>" class="btn btn-secondary">Kembali</a>
  </div>
</form>
<?= $this->endSection() ?>
