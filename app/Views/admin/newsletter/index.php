<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('title') ?>Newsletter<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="fw-bold py-3 mb-4">Kirim Email Promo Newsletter</h4>

<!-- Flash Message -->
<?php if (session()->getFlashdata('success')): ?>
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Berhasil',
      text: '<?= session('success') ?>',
      timer: 3000,
      showConfirmButton: false
    });
  </script>
<?php endif ?>

<?php if (session()->getFlashdata('error')): ?>
  <script>
    Swal.fire({
      icon: 'error',
      title: 'Gagal',
      text: '<?= session('error') ?>',
      timer: 3000,
      showConfirmButton: false
    });
  </script>
<?php endif ?>

<!-- Form Kirim Email -->
<div class="card mb-4">
  <div class="card-body">
    <form action="<?= base_url('admin/newsletter/send') ?>" method="post">
      <?= csrf_field() ?>

      <div class="mb-3">
        <label for="subject" class="form-label">Subjek Email</label>
        <input type="text" name="subject" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="message" class="form-label">Isi Pesan</label>
        <textarea name="message" class="form-control" rows="5" required></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label">Pilih Email Tujuan</label>
        <div class="form-check mb-2">
          <input class="form-check-input" type="checkbox" id="checkAll">
          <label class="form-check-label" for="checkAll">Pilih Semua</label>
        </div>
        <?php foreach ($newsletters as $n): ?>
          <?php if ($n['subscribed']): ?>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="emails[]" value="<?= esc($n['email']) ?>" id="email<?= $n['id'] ?>">
              <label class="form-check-label" for="email<?= $n['id'] ?>"><?= esc($n['email']) ?></label>
            </div>
          <?php endif ?>
        <?php endforeach ?>
      </div>

      <button type="submit" class="btn btn-primary">Kirim Email</button>
    </form>
  </div>
</div>

<!-- Data Subscriber -->
<h4 class="fw-bold py-3 mb-2">Data Email Subscriber</h4>

<div class="d-flex justify-content-between mb-3">
  <h5 class="mb-0">Daftar Newsletter</h5>
  <div>
    <a href="<?= base_url('admin/newsletter/export-pdf') ?>" class="btn btn-danger">Export PDF</a>
    <a href="<?= base_url('admin/newsletter/export-excel') ?>" class="btn btn-success">Export Excel</a>
  </div>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>Email</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($newsletters as $n): ?>
          <tr>
            <td><?= esc($n['email']) ?></td>
            <td>
              <span class="badge <?= $n['subscribed'] ? 'bg-success' : 'bg-secondary' ?>">
                <?= $n['subscribed'] ? 'Aktif' : 'Nonaktif' ?>
              </span>
            </td>
            <td>
              <a href="<?= base_url('admin/newsletter/toggle/' . $n['id']) ?>" class="btn btn-sm btn-info">Toggle</a>
              <a href="<?= base_url('admin/newsletter/delete/' . $n['id']) ?>" class="btn btn-sm btn-danger btn-delete">🗑️</a>
            </td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
</div>

<!-- SweetAlert Konfirmasi Hapus & Check All -->
<script>
  // Konfirmasi hapus
  document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      const href = this.getAttribute('href');
      Swal.fire({
        title: 'Hapus email ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#aaa',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = href;
        }
      });
    });
  });

  // Checkbox pilih semua
  document.getElementById('checkAll').addEventListener('change', function () {
    const checkboxes = document.querySelectorAll('input[name="emails[]"]');
    checkboxes.forEach(c => c.checked = this.checked);
  });
</script>

<?= $this->endSection() ?>
