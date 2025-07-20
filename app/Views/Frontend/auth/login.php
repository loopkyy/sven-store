<?= $this->extend('Frontend/layouts/main') ?>
<?= $this->section('content') ?>

<div class="container my-5" style="max-width: 500px;">
  <h3 class="mb-4 text-center">Login</h3>

  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
  <?php endif; ?>

  <form method="post" action="<?= base_url('login') ?>">
    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" name="email" class="form-control" required value="<?= old('email') ?>">
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary w-100">Login</button>
    <div class="text-center mt-3">
      Belum punya akun? <a href="<?= base_url('register') ?>">Daftar di sini</a>
    </div>
  </form>
</div>

<?= $this->endSection() ?>
