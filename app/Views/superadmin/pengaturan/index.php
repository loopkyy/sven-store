<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('title') ?>Pengaturan<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="fw-bold py-3 mb-4">Pengaturan Sistem</h4>

<?php if(session()->getFlashdata('success')): ?>
  <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
  <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<!-- Form Upload Logo -->
<div class="mb-4">
  <h5>Upload Logo</h5>
  <form action="<?= base_url('superadmin/pengaturan/upload-logo') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="mb-3">
      <input type="file" name="logo" required>
    </div>
    <button type="submit" class="btn btn-primary">Upload Logo</button>
  </form>
  <?php if($logo = get_setting('site_logo')): ?>
    <div class="mt-2">
      <img src="<?= base_url('uploads/' . $logo) ?>" alt="Logo" height="80">
    </div>
  <?php endif; ?>
</div>
<!-- Upload Favicon -->
<div class="mb-4">
  <h5>Upload Favicon (Logo Tab Browser)</h5>
  <form action="<?= base_url('superadmin/pengaturan/upload-favicon') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="mb-3">
      <input type="file" name="favicon" accept=".ico,.png,.svg" required>
    </div>
    <button type="submit" class="btn btn-primary">Upload Favicon</button>
  </form>
  <?php if($favicon = get_setting('site_favicon')): ?>
    <div class="mt-2">
      <img src="<?= base_url('uploads/' . $favicon) ?>" alt="Favicon" height="32">
    </div>
  <?php endif; ?>
</div>


<!-- Form Pengaturan Lain -->
<form action="<?= base_url('superadmin/pengaturan/save') ?>" method="post">
  <?= csrf_field() ?>

  <?php foreach($settings as $setting): ?>
    <?php if(in_array($setting['key_name'], ['site_logo', 'maintenance_mode'])) continue; ?>
    <div class="mb-3">
      <label class="form-label"><?= ucfirst(str_replace('_', ' ', $setting['key_name'])) ?></label>
      <input type="text" name="<?= esc($setting['key_name']) ?>" class="form-control" value="<?= esc($setting['value']) ?>">
    </div>
  <?php endforeach; ?>

  <button type="submit" class="btn btn-success">Simpan Pengaturan</button>
</form>

<!-- Maintenance Mode -->
<div class="mt-4">
  <h5>Maintenance Mode</h5>
  <form action="<?= base_url('superadmin/pengaturan/maintenance') ?>" method="post">
    <?= csrf_field() ?>
    <select name="mode" class="form-select" style="max-width:200px;">
      <option value="off" <?= get_setting('maintenance_mode') === 'off' ? 'selected' : '' ?>>Off</option>
      <option value="on" <?= get_setting('maintenance_mode') === 'on' ? 'selected' : '' ?>>On</option>
    </select>
    <button type="submit" class="btn btn-warning mt-2">Update Maintenance Mode</button>
  </form>
</div>

<?= $pager->links() ?>

<?= $this->endSection() ?>
