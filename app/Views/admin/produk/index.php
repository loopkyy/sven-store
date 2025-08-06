<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('title') ?>Manajemen Produk<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="fw-bold py-3 mb-4">Manajemen Produk</h4>

<a href="<?= base_url('admin/produk/create') ?>" class="btn btn-primary mb-3">➕ Tambah Produk</a>
<a href="<?= base_url('admin/produk/import') ?>" class="btn btn-success mb-3 ms-2">📥 Import Produk</a>
<button class="btn btn-danger mb-3 ms-2" onclick="confirmDeleteAll()">🗑️ Hapus Semua</button>

<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif ?>

<div class="card">
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
  <tr>
    <th>#</th>
    <th>Gambar</th>
    <th>Nama Produk</th>
    <th>Harga</th>
    <th>Stok</th>
    <th>Kategori</th>
    <th>Status</th>
    <th>Terlaris</th>
    <th>Rating</th>
    <th>Aksi</th>
  </tr>
</thead>

      <tbody>
        <?php
          $currentPage = $pager->getCurrentPage() ?? 1;
          $perPage = $pager->getPerPage() ?? 10;
          $startNumber = ($currentPage - 1) * $perPage + 1;
        ?>
        <?php foreach ($products as $index => $produk): ?>
          <tr>
            <td><?= $startNumber + $index ?></td>
            <td>
              <div class="product-image-upload" data-id="<?= $produk['id'] ?>">
                <img src="<?= base_url('uploads/' . ($produk['image'] ?? 'no-image.png')) ?>"
                     alt="Gambar" class="img-thumbnail mb-1"
                     style="width: 70px; height: 70px; object-fit: cover; cursor: pointer;" />
                <input type="file" accept="image/*" style="display: none;" />
              </div>
            </td>
            <td><?= esc($produk['name']) ?></td>
            <td>Rp<?= number_format($produk['price']) ?></td>
            <td><?= $produk['stock'] ?></td>
            <td><?= esc($produk['category_name']) ?></td>
           <td>
  <a href="<?= base_url('admin/produk/edit/' . $produk['id']) ?>" class="btn btn-warning btn-sm" title="Edit">
    <i class="bi bi-pencil-square"></i>
  </a>
  <form action="<?= base_url('admin/produk/delete/' . $produk['id']) ?>" method="post" style="display:inline;" onsubmit="return false;">
    <?= csrf_field() ?>
    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(<?= $produk['id'] ?>)" title="Hapus">
      <i class="bi bi-trash"></i>
    </button>
  </form>
</td>

            <td>
  <?php if ($produk['is_active']): ?>
    <span class="badge bg-success">Aktif</span>
  <?php else: ?>
    <span class="badge bg-secondary">Nonaktif</span>
  <?php endif ?>
</td>

<td>
  <?php if ($produk['is_best_seller']): ?>
    <span class="badge bg-warning text-dark">🔥 Terlaris</span>
  <?php else: ?>
    <span class="text-muted">-</span>
  <?php endif ?>
</td>



          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
</div>

<?= $pager->links('default', 'bootstrap') ?>

<style>
  .product-image-upload input[type="file"] {
    display: none;
  }
  .product-image-upload img:hover {
    opacity: 0.7;
  }
</style>

<script>
  function confirmDelete(id) {
    Swal.fire({
      title: 'Yakin hapus produk ini?',
      text: "Data yang dihapus tidak bisa dikembalikan!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Ya, hapus!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/produk/delete/${id}`;

        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '<?= csrf_token() ?>';
        csrf.value = '<?= csrf_hash() ?>';

        form.appendChild(csrf);
        document.body.appendChild(form);
        form.submit();
      }
    });
  }

  function confirmDeleteAll() {
    Swal.fire({
      title: 'Hapus semua produk?',
      text: "Seluruh data produk akan dihapus permanen!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Ya, hapus semua!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/produk/delete-all`;

        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '<?= csrf_token() ?>';
        csrf.value = '<?= csrf_hash() ?>';

        form.appendChild(csrf);
        document.body.appendChild(form);
        form.submit();
      }
    });
  }

  document.querySelectorAll('.product-image-upload').forEach(container => {
    const input = container.querySelector('input[type="file"]');
    const img = container.querySelector('img');
    const productId = container.dataset.id;

    img.addEventListener('click', () => input.click());

    input.addEventListener('change', async () => {
      const file = input.files[0];
      if (!file) return;

      const formData = new FormData();
      formData.append('image', file);

      const response = await fetch(`/admin/produk/upload-image/${productId}`, {
        method: 'POST',
        body: formData
      });

      const result = await response.json();
      if (result.success) {
        img.src = result.image_url + '?t=' + new Date().getTime();
        Swal.fire('Berhasil!', 'Gambar produk diperbarui.', 'success');
      } else {
        Swal.fire('Gagal', result.message || 'Upload gagal', 'error');
      }
    });
  });
</script>
<?= $this->endSection() ?>
