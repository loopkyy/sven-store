<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('title') ?>Retur Produk<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="fw-bold py-3 mb-4">🔁 Daftar Retur Produk</h4>

<!-- Notifikasi SweetAlert -->
<?php if (session()->getFlashdata('success')): ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Berhasil',
      text: '<?= session('success') ?>',
      timer: 2500,
      showConfirmButton: false
    });
  </script>
<?php endif ?>

<!-- Tombol Atas -->
<div class="mb-3 d-flex justify-content-between">
  <a href="<?= base_url('admin/retur/create') ?>" class="btn btn-primary">+ Pengajuan Retur</a>
  <div>
    <a href="<?= base_url('admin/retur/export-pdf') ?>" class="btn btn-danger">📝 Export PDF</a>
    <a href="<?= base_url('admin/retur/export-excel') ?>" class="btn btn-success">📊 Export Excel</a>
  </div>
</div>

<!-- Tabel Retur -->
<div class="card">
  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Pelanggan</th>
          <th>Alasan</th>
          <th>Status</th>
          <th>Waktu</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($returns as $retur): ?>
        <tr>
          <td><?= $retur['id'] ?></td>
          <td><?= esc($retur['username']) ?></td>
          <td><?= esc($retur['reason']) ?></td>
          <td>
            <form method="post" action="<?= base_url('admin/retur/update-status/' . $retur['id']) ?>">
              <?= csrf_field() ?>
              <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="pending" <?= $retur['status'] == 'pending' ? 'selected' : '' ?>>pending</option>
                <option value="approved" <?= $retur['status'] == 'approved' ? 'selected' : '' ?>>approved</option>
                <option value="rejected" <?= $retur['status'] == 'rejected' ? 'selected' : '' ?>>rejected</option>
              </select>
            </form>
          </td>
          <td><?= date('d M Y H:i', strtotime($retur['created_at'])) ?></td>
          <td>
            <a href="<?= base_url('admin/retur/edit/' . $retur['id']) ?>" class="btn btn-sm btn-warning">✏️ Edit</a>
            <button class="btn btn-sm btn-danger" onclick="confirmDelete(<?= $retur['id'] ?>)">🗑️ Hapus</button>
          </td>
        </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Script Konfirmasi Hapus -->
<script>
function confirmDelete(id) {
  Swal.fire({
    title: 'Yakin ingin menghapus retur?',
    text: 'Data tidak dapat dikembalikan!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = '<?= base_url('admin/retur/delete/') ?>' + id;
    }
  });
}
</script>

<?= $this->endSection() ?>
