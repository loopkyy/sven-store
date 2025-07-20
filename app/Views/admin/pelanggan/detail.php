<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('title') ?>Detail Pelanggan<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="fw-bold py-3 mb-4">Detail Pelanggan</h4>

<div class="card p-3">
  <dl class="row">
    <dt class="col-sm-3">Username</dt>
    <dd class="col-sm-9"><?= esc($pelanggan['username']) ?></dd>

    <dt class="col-sm-3">Email</dt>
    <dd class="col-sm-9"><?= esc($pelanggan['email'] ?? '-') ?></dd>

    <dt class="col-sm-3">No. Telepon</dt>
    <dd class="col-sm-9"><?= esc($pelanggan['phone'] ?? '-') ?></dd>

    <dt class="col-sm-3">Alamat</dt>
    <dd class="col-sm-9"><?= esc($pelanggan['address'] ?? '-') ?></dd>

    <dt class="col-sm-3">Status</dt>
    <dd class="col-sm-9">
      <span class="badge <?= $pelanggan['is_active'] ? 'bg-success' : 'bg-secondary' ?>">
        <?= $pelanggan['is_active'] ? 'Aktif' : 'Nonaktif' ?>
      </span>
    </dd>

    <dt class="col-sm-3">Tanggal Dibuat</dt>
    <dd class="col-sm-9"><?= date('d M Y H:i', strtotime($pelanggan['created_at'])) ?></dd>
  </dl>

  <a href="<?= base_url('admin/pelanggan') ?>" class="btn btn-secondary mt-2">Kembali</a>
</div>
<?= $this->endSection() ?>
