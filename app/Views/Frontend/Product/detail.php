<?= $this->extend('Frontend/layouts/main') ?>
<?= $this->section('content') ?>

<?php
  $kategoriNama = strtolower($product['category_name'] ?? '');
  $kategoriDenganUkuran = ['pakaian wanita', 'pakaian pria', 'loungewear', 'piyama'];
  $butuhUkuran = false;
  foreach ($kategoriDenganUkuran as $keyword) {
    if (strpos($kategoriNama, $keyword) !== false) {
      $butuhUkuran = true;
      break;
    }
  }
?>

<div class="container py-5">
  <div class="row g-5">
    <!-- Gambar Produk -->
    <div class="col-md-6">
      <div class="border rounded shadow-sm p-3 bg-white">
        <img src="<?= base_url('uploads/' . $product['image']) ?>" class="img-fluid rounded" alt="<?= esc($product['name']) ?>">
      </div>
    </div>

    <!-- Detail Produk -->
    <div class="col-md-6">
      <h3 class="fw-bold"><?= esc($product['name']) ?></h3>

      <?php if (!empty($product['is_best_seller'])): ?>
        <span class="badge bg-danger mb-2">🔥 Terlaris</span>
      <?php endif; ?>

      <p class="text-danger fs-4 mb-1">Rp <?= number_format($product['price'], 0, ',', '.') ?></p>
      <p class="text-muted mb-2">Stok: <strong><?= $product['stock'] ?></strong></p>

      <!-- Rating -->
      <div class="text-warning mb-3">
        <?php for ($i = 1; $i <= 5; $i++): ?>
          <i class="bi <?= $i <= $product['rating'] ? 'bi-star-fill' : 'bi-star' ?>"></i>
        <?php endfor ?>
      </div>

      <p><?= esc($product['description']) ?></p>

      <!-- Ukuran (jika perlu) -->
      <?php if ($butuhUkuran): ?>
        <div class="mb-3">
          <label class="form-label fw-bold">Ukuran</label>
          <div class="d-flex gap-2 flex-wrap">
            <?php foreach (['S', 'M', 'L', 'XL'] as $size): ?>
              <button type="button" class="btn btn-outline-danger size-btn px-4 py-2 fw-semibold rounded-pill text-dark" data-size="<?= $size ?>">
                <?= $size ?>
              </button>
            <?php endforeach ?>
          </div>
          <input type="hidden" name="size" id="selected-size" required>
        </div>
      <?php endif; ?>

      <!-- Jumlah -->
      <div class="mb-3">
        <label class="form-label fw-bold">Jumlah</label>
        <div class="input-group" style="max-width: 180px;">
          <button type="button" class="btn btn-outline-danger fw-bold" id="decreaseQty">−</button>
          <input type="number" name="qty" id="qty" class="form-control text-center" value="1" min="1" max="<?= $product['stock'] ?>">
          <button type="button" class="btn btn-outline-danger fw-bold" id="increaseQty">+</button>
        </div>
      </div>

      <!-- Form Tambah ke Keranjang -->
<form method="post" action="<?= base_url('cart/add') ?>" class="mb-2">
  <?= csrf_field() ?>
  <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
  <input type="hidden" name="qty" id="qtyForCart" value="1">
  <?php if ($butuhUkuran): ?>
    <input type="hidden" name="size" id="sizeForCart">
  <?php endif; ?>
  <button type="submit" class="btn btn-dark w-100">
    <i class="bi bi-cart"></i> Tambah ke Keranjang
  </button>
</form>


      <!-- Wishlist -->
      <a href="<?= base_url('wishlist/add/' . $product['id']) ?>" class="btn btn-outline-danger w-100 mb-2">
        <i class="bi bi-heart"></i> Wishlist
      </a>

      <!-- Form Beli Sekarang -->
      <form action="<?= base_url('checkout/direct') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
        <input type="hidden" name="qty" id="qtyForBuy" value="1">
        <?php if ($butuhUkuran): ?>
          <input type="hidden" name="size" id="sizeForBuy">
        <?php endif; ?>
        <button type="submit" class="btn btn-success w-100">
          ⚡ Beli Sekarang
        </button>
      </form>
    </div>
  </div>

  <!-- Produk Lain -->
  <?php if (!empty($relatedProducts)): ?>
    <hr class="my-5">
    <h5 class="mb-3">Produk Lain dalam Kategori Ini</h5>
    <div class="row g-4">
      <?php foreach ($relatedProducts as $item): ?>
        <div class="col-6 col-md-3">
          <a href="<?= base_url('produk/' . $item['slug']) ?>" class="text-decoration-none text-dark">
            <div class="card border-0 shadow-sm h-100">
              <img src="<?= base_url('uploads/' . $item['image']) ?>" class="card-img-top" style="height: 180px; object-fit: cover;" alt="<?= esc($item['name']) ?>">
              <div class="card-body text-center">
                <h6 class="fw-semibold text-truncate mb-1"><?= esc($item['name']) ?></h6>
                <p class="text-danger mb-0">Rp <?= number_format($item['price'], 0, ',', '.') ?></p>
              </div>
            </div>
          </a>
        </div>
      <?php endforeach ?>
    </div>
  <?php endif ?>
</div>

<!-- SCRIPT -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const qtyInput = document.getElementById('qty');
    const qtyForBuy = document.getElementById('qtyForBuy');
    const qtyForCart = document.getElementById('qtyForCart');
    const maxQty = parseInt(qtyInput.max);

    // Ukuran
    const sizeBtns = document.querySelectorAll('.size-btn');
    const selectedSizeInput = document.getElementById('selected-size');
    const sizeForBuy = document.getElementById('sizeForBuy');
    const sizeForCart = document.getElementById('sizeForCart');

    sizeBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        sizeBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        const selected = btn.dataset.size;
        if (selectedSizeInput) selectedSizeInput.value = selected;
        if (sizeForBuy) sizeForBuy.value = selected;
        if (sizeForCart) sizeForCart.value = selected;
      });
    });

    // Qty tombol + -
    document.getElementById('decreaseQty').onclick = () => {
      let val = parseInt(qtyInput.value);
      if (val > 1) {
        qtyInput.value = val - 1;
        qtyForBuy.value = qtyInput.value;
        qtyForCart.value = qtyInput.value;
      }
    };
    document.getElementById('increaseQty').onclick = () => {
      let val = parseInt(qtyInput.value);
      if (val < maxQty) {
        qtyInput.value = val + 1;
        qtyForBuy.value = qtyInput.value;
        qtyForCart.value = qtyInput.value;
      }
    };

    // Sinkron manual ketik qty
    qtyInput.addEventListener('input', () => {
      qtyForBuy.value = qtyInput.value;
      qtyForCart.value = qtyInput.value;
    });
  });
</script>

<style>
  .size-btn {
    transition: 0.2s ease-in-out;
    border-width: 2px;
  }

  .size-btn:hover,
  .size-btn.active {
    background-color: #dc3545 !important;
    color: #fff !important;
    border-color: #dc3545 !important;
  }
</style>

<?= $this->endSection() ?>
