<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('title') ?>Metode Pembayaran<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="fw-bold py-3 mb-4">Metode Pembayaran</h4>

<a href="<?= base_url('admin/pembayaran/create') ?>" class="btn btn-primary mb-3">+ Tambah Metode</a>

<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif ?>

<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif ?>

<div class="card">
  <div class="table-responsive">
    <table class="table table-bordered table-striped">
      <thead class="table-light">
        <tr>
          <th>Nama</th>
          <th>Jenis</th>
          <th>Detail</th>
          <th>Status</th>
          <th style="width: 130px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($methods)): ?>
          <?php foreach ($methods as $method): ?>
            <tr>
              <td><?= esc($method['name']) ?></td>
              <td><?= ucfirst(str_replace('_', ' ', esc($method['type']))) ?></td>
              <td><?= $method['details'] ? esc($method['details']) : '<span class="text-muted">Tidak ada</span>' ?></td>

              <td>
                <span class="badge <?= $method['is_active'] ? 'bg-success' : 'bg-secondary' ?>">
                  <?= $method['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                </span>
              </td>
<td>
  <div class="d-flex gap-2">
    <a href="<?= base_url('admin/pembayaran/edit/' . $method['id']) ?>" class="btn btn-sm btn-warning" title="Edit">
      <i class="bi bi-pencil"></i>
    </a>
    <form action="<?= base_url('admin/pembayaran/delete/' . $method['id']) ?>" method="post" class="form-delete">
      <?= csrf_field() ?>
      <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
        <i class="bi bi-trash"></i>
      </button>
    </form>
  </div>
</td>

            </tr>
          <?php endforeach ?>
        <?php else: ?>
          <tr>
            <td colspan="5" class="text-center">Belum ada metode pembayaran.</td>
          </tr>
        <?php endif ?>
      </tbody>
    </table>
  </div>
</div>

<?= $this->endSection() ?>
<!-- Tambahkan SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  document.querySelectorAll('.form-delete').forEach(form => {
    form.addEventListener('submit', function(e) {
      e.preventDefault(); // cegah submit langsung

      Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Tindakan ini tidak dapat dibatalkan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          form.submit();
        }
      });
    });
  });
</script>
