<?= $this->extend('Frontend/layouts/main') ?>
<?= $this->section('content') ?>

<div class="container my-5" style="max-width: 500px;">
  <h3 class="mb-4 text-center">Daftar</h3>

  <?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
      <ul class="mb-0">
        <?php foreach (session()->getFlashdata('errors') as $err): ?>
          <li><?= $err ?></li>
        <?php endforeach ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="post" action="<?= base_url('register') ?>">
    <div class="mb-3">
      <label for="username" class="form-label">Nama Pengguna</label>
      <input type="text" name="username" class="form-control" value="<?= old('username') ?>" required>
    </div>
    <!-- No HP -->
<div class="mb-3">
  <label for="phone" class="form-label">No HP</label>
  <input type="text" class="form-control" id="phone" name="phone" required>
</div>

<!-- Alamat -->
<div class="mb-3">
  <label for="address" class="form-label">Alamat</label>
  <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
</div>

    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" name="email" class="form-control" value="<?= old('email') ?>" required>
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success w-100">Daftar</button>
    <div class="text-center mt-3">
      Sudah punya akun? <a href="<?= base_url('login') ?>">Login di sini</a>
    </div>
  </form>
</div>

<?= $this->endSection() ?>
