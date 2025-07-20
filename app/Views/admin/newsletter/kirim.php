<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('title') ?>Kirim Email Promo<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="fw-bold mb-3">Kirim Email Promo</h4>

<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success"><?= session('success') ?></div>
<?php endif ?>

<form action="<?= base_url('admin/newsletter/kirim') ?>" method="post">
  <?= csrf_field() ?>

  <div class="mb-3">
    <label for="subject" class="form-label">Subjek Email</label>
    <input type="text" name="subject" class="form-control" required>
  </div>

  <div class="mb-3">
    <label for="message" class="form-label">Isi Pesan</label>
    <textarea name="message" rows="6" class="form-control" required></textarea>
  </div>

  <div class="mb-3">
    <label class="form-label">Target Email</label>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="checkAll">
      <label class="form-check-label" for="checkAll">Pilih Semua</label>
    </div>
    <?php foreach ($emails as $e): ?>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="emails[]" value="<?= esc($e['email']) ?>" id="email_<?= $e['id'] ?>">
        <label class="form-check-label" for="email_<?= $e['id'] ?>"><?= esc($e['email']) ?></label>
      </div>
    <?php endforeach ?>
  </div>

  <button class="btn btn-primary">Kirim Email</button>
</form>

<script>
  document.getElementById('checkAll').addEventListener('change', function () {
    document.querySelectorAll('input[type="checkbox"][name="emails[]"]').forEach(el => el.checked = this.checked);
  });
</script>

<?= $this->endSection() ?>
