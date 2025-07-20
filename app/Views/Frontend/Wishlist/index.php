<?= $this->extend('Frontend/layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-5">
  <h4 class="mb-4 fw-bold">Wishlist Saya</h4>

  <?php if (empty($products)): ?>
    <div class="alert alert-warning">
  Belum ada produk di wishlist kamu. 
  Yuk <a href="<?= base_url('produk') ?>" class="text-decoration-none fw-semibold">
    jelajahi produk <i class="bi bi-box-arrow-up-right"></i>
  </a>!
</div>

  <?php else: ?>
    <div class="row g-4">
      <?php foreach ($products as $product): ?>
        <div class="col-6 col-md-3">
          <div class="card border-0 shadow-sm h-100">
            <a href="<?= base_url('produk/' . $product['slug']) ?>" class="text-decoration-none text-dark">
              <img src="<?= base_url('uploads/' . $product['image']) ?>" class="card-img-top" style="height: 180px; object-fit: cover;" alt="<?= esc($product['name']) ?>">
              <div class="card-body text-center">
                <h6 class="fw-semibold text-truncate mb-1"><?= esc($product['name']) ?></h6>
                <p class="text-danger mb-0">Rp <?= number_format($product['price'], 0, ',', '.') ?></p>
              </div>
            </a>
            <div class="card-footer bg-white text-center">
              <a href="<?= base_url('wishlist/remove/' . $product['id']) ?>" class="btn btn-sm btn-outline-danger">
                <i class="bi bi-trash"></i> Hapus
              </a>
              <a href="<?= base_url('cart/add/' . $product['id']) ?>" class="btn btn-sm btn-dark ms-2">
                <i class="bi bi-cart"></i> Beli
              </a>
            </div>
          </div>
        </div>
      <?php endforeach ?>
    </div>
  <?php endif ?>
</div>

<?= $this->endSection() ?>
