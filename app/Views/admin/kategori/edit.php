<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('title') ?>Edit Kategori<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card">
  <div class="card-body">
    <h5 class="card-title mb-4">Edit Kategori</h5>

    <form action="<?= base_url('admin/kategori/update/' . $kategori['id']) ?>" method="post">
      <div class="mb-3">
        <label for="name" class="form-label fw-bold">Nama Kategori</label>
        <input type="text" name="name" id="name" class="form-control" value="<?= esc($kategori['name']) ?>" required>
      </div>

      <div class="mb-3">
        <label for="description" class="form-label fw-bold">Deskripsi</label>
        <textarea name="description" id="description" class="form-control" rows="3"><?= esc($kategori['description']) ?></textarea>
      </div>

      <button type="submit" class="btn btn-warning">Update</button>
      <a href="<?= base_url('admin/kategori') ?>" class="btn btn-secondary">Batal</a>
    </form>
  </div>
</div>
<?= $this->endSection() ?>
