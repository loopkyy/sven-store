<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('title') ?>Manajemen Pelanggan<?= $this->endSection() ?>
<?= $this->section('content') ?>

<h4 class="fw-bold py-3 mb-4">📋 Manajemen Pelanggan</h4>

<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php elseif (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif ?>

<div class="card">
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>Username</th>
          <th>Email</th>
          <th>No HP</th>
          <th>Alamat</th>
          <th>Status</th>
          <th>Dibuat</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($customers as $c): ?>
        <tr>
          <td><?= esc($c['username']) ?></td>
          <td><?= esc($c['email'] ?? '-') ?></td>
          <td><?= esc($c['phone'] ?? '-') ?></td>
          <td><?= esc($c['address'] ?? '-') ?></td>
<td>
  <a href="<?= base_url('admin/pelanggan/toggle/' . $c['id']) ?>" 
     class="badge <?= $c['is_active'] ? 'bg-success' : 'bg-secondary' ?>" 
     onclick="return confirm('Yakin ingin mengubah status pelanggan ini?')">
    <?= $c['is_active'] ? 'Aktif' : 'Nonaktif' ?>
  </a>
</td>

<td><?= date('d M Y H:i', strtotime($c['created_at'])) ?></td>
<td>
  <div class="d-flex gap-2">
    <a href="<?= base_url('admin/pelanggan/detail/' . $c['id']) ?>" class="btn btn-sm btn-info" title="Detail">
      <i class="bi bi-eye"></i>
    </a>
    <a href="<?= base_url('admin/pelanggan/edit/' . $c['id']) ?>" class="btn btn-sm btn-warning" title="Edit">
      <i class="bi bi-pencil"></i>
    </a>
    <form action="<?= base_url('admin/pelanggan/delete/' . $c['id']) ?>" method="post" class="form-delete">
      <?= csrf_field() ?>
      <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
        <i class="bi bi-trash"></i>
      </button>
    </form>
  </div>
</td>



        </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
</div>

<?= $this->endSection() ?>
