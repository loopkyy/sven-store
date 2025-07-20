<?= $this->extend('Frontend/layouts/main') ?>
<?= $this->section('content') ?>

<div class="container my-5">
  <!-- Alert Selamat Datang -->
  <div class="alert alert-success d-flex align-items-center fade-in mb-4" role="alert">
    <i class="bi bi-person-circle me-2 fs-4"></i>
    <div>
      Selamat datang, <strong><?= esc($user['user_name'] ?? 'Pengguna') ?></strong>! Senang melihatmu kembali 😊
    </div>
  </div>

  <h2 class="mb-4">Akun Saya</h2>

  <div class="d-flex flex-column gap-3">
    <div class="p-3 border rounded shadow-sm hover-red">
      <strong>Nama:</strong> <?= esc($user['user_name'] ?? '-') ?>
    </div>
    <div class="p-3 border rounded shadow-sm hover-red">
      <strong>Email:</strong> <?= esc($user['user_email'] ?? '-') ?>
    </div>
    <div class="p-3 border rounded shadow-sm hover-red">
      <strong>No. HP:</strong> <?= esc($user['phone'] ?? '-') ?>
    </div>
    <div class="p-3 border rounded shadow-sm hover-red">
      <strong>Alamat:</strong> <?= esc($user['address'] ?? '-') ?>
    </div>
  </div>

  <div class="mt-4">
    <a href="<?= base_url('logout') ?>" class="btn btn-outline-danger">
      <i class="bi bi-box-arrow-right me-1"></i> Logout
    </a>
  </div>
</div>

<style>
  .hover-red:hover {
    border-color: red !important;
    transition: 0.3s;
  }

  .fade-in {
    animation: fadeIn 0.8s ease-in-out;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
  }
</style>

<?= $this->endSection() ?>
