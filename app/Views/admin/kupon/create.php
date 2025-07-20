<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('title') ?>Tambah Kupon<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="fw-bold py-3 mb-4">Tambah Kupon Diskon</h4>

<?php if (session()->getFlashdata('error')): ?>
  <script>
    Swal.fire({
      icon: 'error',
      title: 'Gagal',
      text: '<?= session('error') ?>',
      timer: 3000,
      showConfirmButton: false
    });
  </script>
<?php endif ?>

<?php if (session('errors')): ?>
  <div class="alert alert-danger">
    <ul class="mb-0">
      <?php foreach (session('errors') as $error): ?>
        <li><?= esc($error) ?></li>
      <?php endforeach ?>
    </ul>
  </div>
<?php endif ?>

<form action="<?= base_url('admin/kupon/store') ?>" method="post">
  <?= csrf_field() ?>
  <div class="card p-4">
    <div class="mb-3">
      <label for="code" class="form-label">Kode Kupon</label>
      <input type="text" name="code" class="form-control" value="<?= old('code') ?>" required>
    </div>

 <select name="type" class="form-select" required>
  <option value="percentage">Persentase</option>
  <option value="fixed">Nominal</option>
</select>
>


    <div class="mb-3">
      <label for="value" class="form-label">Nilai</label>
      <input type="number" name="value" class="form-control" value="<?= old('value') ?>" required>
    </div>

    <div class="mb-3">
      <label for="max_uses" class="form-label">Maks. Penggunaan</label>
      <input type="number" name="max_uses" class="form-control" value="<?= old('max_uses') ?>" required>
    </div>

    <div class="mb-3">
      <label for="start_date" class="form-label">Tanggal Mulai</label>
      <input type="date" name="start_date" class="form-control" value="<?= old('start_date') ?>" required>
    </div>

    <div class="mb-3">
      <label for="end_date" class="form-label">Tanggal Berakhir</label>
      <input type="date" name="end_date" class="form-control" value="<?= old('end_date') ?>" required>
    </div>

    <div class="form-check form-switch mb-3">
      <input class="form-check-input" type="checkbox" name="is_active" value="1" <?= old('is_active', '1') ? 'checked' : '' ?>>
      <label class="form-check-label">Aktif</label>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="<?= base_url('admin/kupon') ?>" class="btn btn-secondary">Kembali</a>
  </div>
</form>

<?= $this->endSection() ?>
