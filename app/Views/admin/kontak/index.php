<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('title') ?>Kontak Masuk<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="fw-bold py-3 mb-4">Kontak Masuk</h4>

<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= session()->getFlashdata('success') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php elseif (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?= session()->getFlashdata('error') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<div class="card">
  <div class="table-responsive">
    <table class="table table-striped table-hover">
      <thead class="table-light">
        <tr>
          <th>Nama</th>
          <th>Email</th>
          <th>Pesan</th>
          <th>Tanggal</th>
          <th>Status</th>
          <th style="width: 100px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($contacts)): ?>
          <?php foreach ($contacts as $contact): ?>
            <tr>
              <td><?= esc($contact['name']) ?></td>
              <td><?= esc($contact['email']) ?></td>
              <td><?= esc($contact['message']) ?></td>
              <td><?= date('d M Y H:i', strtotime($contact['created_at'])) ?></td>
              <td>
                <span class="badge <?= $contact['status'] === 'new' ? 'bg-warning text-dark' : 'bg-success' ?>">
                  <?= ucfirst($contact['status']) ?>
                </span>
              </td>
              <td>
                <div class="d-flex gap-1">
                  <?php if ($contact['status'] === 'new'): ?>
                    <a href="<?= base_url('kontak/mark-read/' . $contact['id']) ?>" class="btn btn-sm btn-outline-success" title="Tandai sudah dibaca">
                      <i class="bx bx-check"></i>
                    </a>
                  <?php endif ?>
                  <a href="<?= base_url('kontak/delete/' . $contact['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus pesan ini?')" title="Hapus pesan">
                    <i class="bx bx-trash"></i>
                  </a>
                </div>
              </td>
            </tr>
          <?php endforeach ?>
        <?php else: ?>
          <tr>
            <td colspan="6" class="text-center">Tidak ada pesan masuk.</td>
          </tr>
        <?php endif ?>
      </tbody>
    </table>
  </div>
</div>
<?= $this->endSection() ?>
