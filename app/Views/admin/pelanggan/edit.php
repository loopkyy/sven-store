<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('title') ?>Edit Pelanggan<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="fw-bold py-3 mb-4">🛠️ Edit Data Pelanggan</h4>

<form action="<?= base_url("admin/pelanggan/update/{$pelanggan['id']}") ?>" method="post">
  <?= csrf_field() ?>

  <div class="mb-3">
    <label for="username" class="form-label">Username</label>
    <input type="text" id="username" name="username" class="form-control" 
      value="<?= esc($pelanggan['username']) ?>" required>
  </div>

  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" id="email" name="email" class="form-control" 
      value="<?= esc($pelanggan['email'] ?? '') ?>">
  </div>

  <div class="mb-3">
    <label for="phone" class="form-label">No. Telepon</label>
    <input type="text" id="phone" name="phone" class="form-control" 
      value="<?= esc($pelanggan['phone'] ?? '') ?>">
  </div>

  <div class="mb-3">
    <label for="address" class="form-label">Alamat</label>
    <textarea id="address" name="address" class="form-control" rows="3"><?= esc($pelanggan['address'] ?? '') ?></textarea>
  </div>

  <div class="mb-3">
    <label for="is_active" class="form-label">Status Akun</label>
    <select id="is_active" name="is_active" class="form-select">
      <option value="1" <?= $pelanggan['is_active'] ? 'selected' : '' ?>>Aktif</option>
      <option value="0" <?= !$pelanggan['is_active'] ? 'selected' : '' ?>>Nonaktif</option>
    </select>
  </div>

  <button type="submit" class="btn btn-primary">💾 Simpan</button>
  <a href="<?= base_url('admin/pelanggan') ?>" class="btn btn-secondary">↩️ Kembali</a>
</form>
<?= $this->endSection() ?>
