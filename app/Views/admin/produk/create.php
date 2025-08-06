<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('title') ?>Tambah Produk<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card">
  <div class="card-body">
    <h5 class="card-title mb-4">Tambah Produk</h5>

<form action="<?= base_url('admin/produk/store') ?>" method="post" enctype="multipart/form-data">



      <div class="mb-3">
        <label for="name" class="form-label fw-bold">Nama Produk</label>
        <input type="text" name="name" id="name" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="description" class="form-label fw-bold">Deskripsi</label>
        <textarea name="description" id="description" class="form-control" rows="3"></textarea>
      </div>

      <div class="mb-3">
        <label for="price" class="form-label fw-bold">Harga</label>
        <input type="text" name="price" id="price" class="form-control format-rupiah" required>

      </div>

      <div class="mb-3">
        <label for="stock" class="form-label fw-bold">Stok</label>
        <input type="number" name="stock" id="stock" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="category_id" class="form-label fw-bold">Kategori</label>
        <select name="category_id" id="category_id" class="form-control" required>
          <option value="">-- Pilih Kategori --</option>
          <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="image" class="form-label fw-bold">Gambar Produk</label>
        <input type="file" name="image" id="image" class="form-control">
      </div>

      <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="<?= base_url('admin/produk') ?>" class="btn btn-secondary">Kembali</a>
    </form>
  </div>
</div>
<?= $this->endSection() ?>
