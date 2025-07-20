<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('title') ?>Manajemen Kategori<?= $this->endSection() ?>
<?= $this->section('content') ?>

<h4 class="fw-bold py-3 mb-4">Manajemen Kategori</h4>

<a href="<?= base_url('/admin/kategori/create') ?>" class="btn btn-primary mb-3">➕ Tambah Kategori</a>


<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif ?>

<div class="card">
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>Nama</th>
          <th>Deskripsi</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($categories as $index => $cat): ?>
        <tr>
          <td><?= $index + 1 ?></td>
          <td><?= esc($cat['name']) ?></td>
          <td><?= esc($cat['description']) ?></td>
<td>
  <a href="<?= base_url('/admin/kategori/edit/' . $cat['id']) ?>" class="btn btn-warning btn-sm" title="Edit">
    <i class="bi bi-pencil-square"></i>
  </a>

  <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="<?= $cat['id'] ?>" title="Hapus">
    <i class="bi bi-trash"></i>
  </button>
</td>


        </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
</div>
<script>
  document.querySelectorAll('.btn-delete').forEach(button => {
    button.addEventListener('click', function () {
      const id = this.dataset.id;

      Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#aaa',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          // Redirect ke controller delete
          window.location.href = `/admin/kategori/delete/${id}`;

        }
      });
    });
  });
</script>
<?= $this->endSection() ?>
