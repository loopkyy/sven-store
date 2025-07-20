<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('title') ?>Manajemen Admin<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="fw-bold py-3 mb-4">Manajemen Admin</h4>

<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<a href="<?= base_url('superadmin/create') ?>" class="btn btn-primary mb-3">➕ Tambah Admin</a>

<div class="card">
  <div class="card-body table-responsive">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>Username</th>
          <th>Email</th>
          <th>Status</th>
          <th>Dibuat</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($admins)): ?>
          <tr>
            <td colspan="6" class="text-center">Tidak ada data admin.</td>
          </tr>
        <?php else: ?>
          <?php $no = 1; foreach ($admins as $admin): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= esc($admin['username']) ?></td>
              <td><?= esc($admin['email']) ?></td>
              <td>
                <a href="javascript:void(0)" class="badge <?= $admin['is_active'] ? 'bg-success' : 'bg-secondary' ?>" onclick="confirmToggle(<?= $admin['id'] ?>, '<?= esc($admin['username']) ?>', <?= $admin['is_active'] ?>)">
                  <?= $admin['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                </a>
              </td>
              <td><?= date('d/m/Y H:i', strtotime($admin['created_at'])) ?></td>
              <td>
                <a href="<?= base_url('superadmin/edit/' . $admin['id']) ?>" class="btn btn-sm btn-warning">✏ Edit</a>
                <button class="btn btn-sm btn-danger" onclick="confirmDelete(<?= $admin['id'] ?>)">🗑 Hapus</button>
              </td>
            </tr>
          <?php endforeach ?>
        <?php endif ?>
      </tbody>
    </table>
  </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  function confirmDelete(id) {
    Swal.fire({
      title: 'Yakin hapus admin?',
      text: "Data tidak bisa dikembalikan!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#aaa',
      confirmButtonText: 'Ya, hapus!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '<?= base_url('superadmin/delete') ?>/' + id;
      }
    });
  }

  function confirmToggle(id, username, isActive) {
    const action = isActive ? 'Nonaktifkan' : 'Aktifkan';
    Swal.fire({
      title: `${action} admin ini?`,
      text: `Admin: ${username}`,
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: `Ya, ${action}`,
      cancelButtonText: 'Batal',
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#aaa',
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '<?= base_url('superadmin/toggle') ?>/' + id;
      }
    });
  }
</script>
<?= $this->endSection() ?>
