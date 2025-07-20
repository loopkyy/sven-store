<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('title') ?>Log Aktivitas<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="fw-bold py-3 mb-4">Log Aktivitas</h4>

<div class="card">
  <div class="table-responsive">

    <!-- 🔍 Form Pencarian -->
    <form method="get" action="<?= base_url('superadmin/log') ?>" class="mb-3">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Cari aktivitas..." value="<?= esc($_GET['q'] ?? '') ?>">
        <button class="btn btn-primary" type="submit">Cari</button>
      </div>
    </form>

    <!-- 🗑 Tombol Hapus Semua -->
    <div class="mb-3">
      <button class="btn btn-danger" id="btn-delete-all">Hapus Semua Log</button>
    </div>

    <!-- 📋 Tabel Log -->
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Waktu</th>
          <th>Pengguna</th>
          <th>Aktivitas</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($logs as $log): ?>
          <tr>
            <td><?= date('d M Y H:i', strtotime($log['created_at'])) ?></td>
            <td><?= esc($log['username'] ?? 'System') ?></td>
            <td><?= esc($log['activity']) ?></td>
            <td>
              <button class="btn btn-sm btn-danger btn-delete-log" data-id="<?= $log['id'] ?>">Hapus</button>
            </td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>

    <?= $pager->links() ?>

  </div>
</div>

<!-- 🔁 Script Hapus Per Baris -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  const deleteButtons = document.querySelectorAll('.btn-delete-log');

  deleteButtons.forEach(button => {
    button.addEventListener('click', function () {
      const logId = this.dataset.id;

      Swal.fire({
        title: 'Yakin mau hapus log ini?',
        text: "Data akan hilang permanen.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          fetch(`<?= base_url('superadmin/log/delete/') ?>${logId}`, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
            }
          }).then(response => {
            if (response.ok) {
              Swal.fire('Berhasil!', 'Log telah dihapus.', 'success').then(() => {
                location.reload();
              });
            } else {
              Swal.fire('Gagal!', 'Gagal menghapus log.', 'error');
            }
          });
        }
      });
    });
  });
});
</script>

<!-- 🔁 Script Hapus Semua -->
<script>
document.getElementById('btn-delete-all').addEventListener('click', function () {
  Swal.fire({
    title: 'Yakin hapus SEMUA log aktivitas?',
    text: "Ini akan menghapus semua log yang ada!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Ya, hapus semua!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      fetch('<?= base_url('superadmin/log/delete-all') ?>', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
        }
      }).then(response => {
        if (response.ok) {
          Swal.fire('Berhasil!', 'Semua log telah dihapus.', 'success').then(() => {
            location.reload();
          });
        } else {
          Swal.fire('Gagal!', 'Gagal menghapus semua log.', 'error');
        }
      });
    }
  });
});
</script>

<?= $this->endSection() ?>
