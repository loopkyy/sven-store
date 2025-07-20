<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('title') ?>Manajemen Restok<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="fw-bold mb-3">Manajemen Restok</h4>

<?php if (session()->getFlashdata('success')): ?>
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: '<?= session('success') ?>',
      showConfirmButton: false,
      timer: 2000
    });
  </script>
<?php endif ?>


<table class="table table-bordered">
  <thead>
    <tr>
      <th>Nama Produk</th>
      <th>Stok Saat Ini</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($products as $produk): ?>
      <tr>
        <td><?= esc($produk['name']) ?></td>
        <td><?= $produk['stock'] ?></td>
        <td>
          <a href="<?= base_url('admin/restok/tambah/' . $produk['id']) ?>" class="btn btn-sm btn-primary">➕ Tambah Stok</a>
        </td>
      </tr>
    <?php endforeach ?>
  </tbody>
</table>
<?= $this->endSection() ?>
