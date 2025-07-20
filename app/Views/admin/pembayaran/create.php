<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('title') ?>Tambah Metode Pembayaran<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="fw-bold py-3 mb-4">Tambah Metode Pembayaran</h4>

<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif ?>
<?php if (session('errors')): ?>
  <div class="alert alert-danger">
    <ul class="mb-0">
      <?php foreach (session('errors') as $error): ?>
        <li><?= esc($error) ?></li>
      <?php endforeach ?>
    </ul>
  </div>
<?php endif ?>

<form action="<?= base_url('admin/pembayaran/store') ?>" method="post">
  <?= csrf_field() ?>
  <div class="card p-4">
    <div class="mb-3">
      <label for="name" class="form-label">Nama Metode</label>
      <input type="text" name="name" class="form-control" value="<?= old('name') ?>" required>
    </div>

    <div class="mb-3">
      <label for="type" class="form-label">Jenis</label>
      <select name="type" class="form-select" required>
        <option value="">-- Pilih Jenis --</option>
        <option value="cod" <?= old('type') === 'cod' ? 'selected' : '' ?>>COD</option>
        <option value="bank_transfer" <?= old('type') === 'bank_transfer' ? 'selected' : '' ?>>Transfer Bank</option>
        <option value="qris" <?= old('type') === 'qris' ? 'selected' : '' ?>>QRIS</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="details" class="form-label">Detail</label>
      <textarea name="details" class="form-control" rows="3" placeholder="Contoh: No rekening atau info QRIS"><?= old('details') ?></textarea>

    </div>

    <div class="form-check form-switch mb-3">
    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?= old('is_active', '1') ? 'checked' : '' ?>>
<label class="form-check-label" for="is_active">Aktifkan Metode</label>

    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="<?= base_url('admin/pembayaran') ?>" class="btn btn-secondary">Kembali</a>
  </div>
</form>
<?= $this->endSection() ?>
