<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('title') ?>Kupon / Diskon<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="fw-bold py-3 mb-4">Manajemen Kupon</h4>

<?php if (session()->getFlashdata('success')): ?>
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Berhasil',
      text: '<?= session('success') ?>',
      timer: 2000,
      showConfirmButton: false
    });
  </script>
<?php endif ?>

<div class="d-flex justify-content-between mb-3">
  <a href="<?= base_url('admin/kupon/create') ?>" class="btn btn-primary">➕ Tambah Kupon</a>
  <div>
    <a href="<?= base_url('admin/kupon/export-pdf') ?>" class="btn btn-danger">Export PDF</a>
    <a href="<?= base_url('admin/kupon/export-excel') ?>" class="btn btn-success">Export Excel</a>
  </div>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>Kode</th>
          <th>Jenis</th>
          <th>Nilai</th>
          <th>Maks. Penggunaan</th>
          <th>Tanggal Berlaku</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($coupons as $c): ?>
          <tr>
            <td><?= esc($c['code']) ?></td>
            <td><?= esc($c['type']) ?></td>
        <td>
  <?= esc($c['type'] === 'percentage' ? 'Persentase' : 'Nominal') ?>
</td>
            <td><?= esc($c['used_count']) ?>/<?= esc($c['max_uses']) ?></td>
            <td><?= esc($c['start_date']) ?> s/d <?= esc($c['end_date']) ?></td>
            <td>
            <a href="<?= base_url('admin/kupon/toggle/' . $c['id']) ?>" 
   class="badge toggle-status <?= $c['is_active'] ? 'bg-success' : 'bg-secondary' ?>" 
   data-status="<?= $c['is_active'] ? 'nonaktifkan' : 'aktifkan' ?>">
   <?= $c['is_active'] ? 'Aktif' : 'Nonaktif' ?>
</a>
            </td>
          <td>
  <div class="d-flex gap-2">
    <a href="<?= base_url('admin/kupon/edit/' . $c['id']) ?>" class="btn btn-sm btn-warning" title="Edit">
      <i class="bi bi-pencil"></i>
    </a>
    <a href="<?= base_url('admin/kupon/delete/' . $c['id']) ?>" class="btn btn-sm btn-danger btn-delete" title="Hapus">
      <i class="bi bi-trash"></i>
    </a>
  </div>
</td>


          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
    <script>
document.querySelectorAll('.toggle-status').forEach(btn => {
  btn.addEventListener('click', function(e) {
    e.preventDefault();
    const href = this.getAttribute('href');
    const action = this.dataset.status;

    Swal.fire({
      title: `Yakin ingin ${action} kupon ini?`,
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya, lanjut!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = href;
      }
    });
  });
});
</script>

  </div>
</div>

<!-- SweetAlert2 untuk konfirmasi hapus -->
<script>
  document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      const href = this.getAttribute('href');
      Swal.fire({
        title: 'Yakin ingin menghapus kupon ini?',
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
</script>
<?php if (session()->getFlashdata('success')): ?>
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Berhasil',
      text: '<?= session()->getFlashdata('success') ?>',
      timer: 2000,
      showConfirmButton: false
    });
  </script>
<?php endif ?>

<?php if (session()->getFlashdata('error')): ?>
  <script>
    Swal.fire({
      icon: 'error',
      title: 'Gagal',
      text: '<?= session()->getFlashdata('error') ?>',
      timer: 3000,
      showConfirmButton: false
    });
  </script>
<?php endif ?>

<?= $this->endSection() ?>
