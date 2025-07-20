<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('title') ?>Tambah Admin<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="fw-bold py-3 mb-4">Tambah Admin</h4>

<?php if (session()->getFlashdata('errors')): ?>
  <div class="alert alert-danger">
    <ul class="mb-0">
      <?php foreach (session()->getFlashdata('errors') as $error): ?>
        <li><?= esc($error) ?></li>
      <?php endforeach ?>
    </ul>
  </div>
<?php endif; ?>

<form action="<?= base_url('superadmin/store') ?>" method="post">
  <?= csrf_field() ?>

  <div class="mb-3">
    <label class="form-label">Username</label>
    <input type="text" name="username" class="form-control" value="<?= old('username') ?>" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control" value="<?= old('email') ?>" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Password</label>
    <input type="password" name="password" class="form-control" required>
  </div>

  <button type="submit" class="btn btn-primary">Simpan</button>
  <a href="<?= base_url('superadmin') ?>" class="btn btn-secondary">Kembali</a>
</form>
<?= $this->endSection() ?>
