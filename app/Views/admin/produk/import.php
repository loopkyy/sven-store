<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>
<h4>Import Produk</h4>

<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<a href="<?= base_url('uploads/produk_template.xlsx') . '?t=' . time() ?>" class="btn btn-info mb-3">📥 Download Template</a>


<form action="<?= base_url('admin/produk/import') ?>" method="post" enctype="multipart/form-data">
  <div class="mb-3">
    <label for="file_excel">Upload File Excel</label>
    <input type="file" name="file_excel" class="form-control" required>
  </div>
  <button class="btn btn-primary">Import</button>
</form>
<?= $this->endSection() ?>
