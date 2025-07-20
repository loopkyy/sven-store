<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('title') ?>Tambah Kategori<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card">
  <div class="card-body">
    <h5 class="card-title mb-4">Tambah Kategori</h5>

    <form action="<?= base_url('admin/kategori/store') ?>" method="post">
      <div class="mb-3">
        <label for="name" class="form-label fw-bold">Nama Kategori</label>
        <input type="text" name="name" id="name" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="description" class="form-label fw-bold">Deskripsi</label>
        <textarea name="description" id="description" class="form-control" rows="3"></textarea>
      </div>

      <button type="submit" class="btn btn-primary">Simpan</button>
     <a href="<?= base_url('/admin/kategori') ?>" class="btn btn-secondary">Kembali</a>

    </form>
  </div>
</div>
<?= $this->endSection() ?>
