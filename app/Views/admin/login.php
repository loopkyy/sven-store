<?= $this->extend('admin/layouts/blank') ?>



<?= $this->section('content') ?>
<div class="vh-100 d-flex justify-content-center align-items-center bg-light">
  <div class="card p-4 shadow" style="width: 350px;">
    <h4 class="text-center fw-bold mb-3">Login Admin</h4>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger small"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success small"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>


  <form method="post" action="<?= base_url('admin/login/authenticate') ?>">


      <?= csrf_field() ?>
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" name="username" id="username" class="form-control" required autofocus>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" id="password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Masuk</button>
    </form>
  </div>
</div>
<?= $this->endSection() ?>
