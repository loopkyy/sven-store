<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('title') ?>Tambah Stok<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="fw-bold mb-3">Tambah Stok: <?= esc($product['name']) ?></h4>

<form method="post" action="<?= base_url('admin/restok/simpan/' . $product['id']) ?>">
  <div class="mb-3">
    <label for="jumlah" class="form-label fw-bold">Jumlah Tambah Stok</label>
    <input type="number" name="jumlah" id="jumlah" class="form-control" required min="1">
  </div>

  <button type="submit" class="btn btn-success">Simpan</button>
  <a href="<?= base_url('admin/restok') ?>" class="btn btn-secondary">Kembali</a>
</form>
<?= $this->endSection() ?>
