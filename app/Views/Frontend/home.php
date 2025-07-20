
<?= $this->extend('Frontend/layouts/main') ?>

<?= $this->section('content') ?>

<!-- Hero Banner Carousel -->
<section class="py-4">
  <div class="container px-0">
    <div class="owl-carousel owl-theme hero-carousel">
      <?php
        $banners = [
          ['image' => '1.png', 'text' => 'Fashion Terkini'],
          ['image' => '2.png', 'text' => 'Diskon Menarik'],
        ];
      ?>
      <?php foreach ($banners as $b): ?>
        <div class="position-relative" style="height: 500px; background-image: url('<?= base_url('assets/frontend/images/banner/' . $b['image']) ?>'); background-size: cover; background-position: center;">
          
          <!-- Overlay gelap -->
          <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(0, 0, 0, 0.4); z-index: 1;"></div>
          
          <!-- Konten -->
          <div class="position-absolute top-50 start-50 translate-middle text-white text-center" style="z-index: 2;">
            <h1 class="display-4 fw-bold text-shadow"><?= esc($b['text']) ?></h1>
            <a href="<?= base_url('produk') ?>" class="btn btn-danger mt-3 px-4 py-2 shadow-lg fw-semibold" style="border-radius: 50px; font-size: 1.1rem;">
              Belanja Sekarang
            </a>
          </div>
        </div>
      <?php endforeach ?>
    </div>
  </div>
</section>

<style>
.kategori-icon-wrapper {
  width: 80px;
  height: 80px;
  border: 2px solid #ccc;
  border-radius: 50%;
  padding: 15px;
  transition: border-color 0.3s;
}
.kategori-icon-wrapper:hover {
  border-color: red;
}
.kategori-icon-wrapper img {
  max-width: 100%;
  max-height: 100%;
  object-fit: contain;
}
.kategori-icon-wrapper:hover {
  border-color: red;
  background-color: #fff5f5;
}
.text-shadow {
  text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
}
.btn-danger {
  background-color: #dc3545;
  border: none;
  transition: background-color 0.3s ease, transform 0.2s ease;
}

.btn-danger:hover {
  background-color: #c82333;
  transform: scale(1.05);
}

</style>

<section class="py-5 bg-light">
  <div class="container">
    <div class="owl-carousel owl-theme kategori-carousel">
      <?php
        $kategori = [
  ['icon' => '1.png', 'label' => 'Pakaian Wanita', 'slug' => 'pakaian-wanita'],
  ['icon' => '2a.png', 'label' => 'Pakaian Pria', 'slug' => 'pakaian-pria'],
  ['icon' => '3a.png', 'label' => 'Tas & Dompet', 'slug' => 'tas-dompet'],
  ['icon' => '4a.png', 'label' => 'Sepatu & Sandal', 'slug' => 'sepatu-sandal'],
  ['icon' => '5a.png', 'label' => 'Aksesori Fashion', 'slug' => 'aksesori-fashion'],
  ['icon' => '6a.png', 'label' => 'Skincare & Bodycare', 'slug' => 'skincare-bodycare'],
  ['icon' => '7.png', 'label' => 'Kosmetik & Makeup', 'slug' => 'kosmetik-makeup'],
  ['icon' => '8.png', 'label' => 'Parfum & Wewangian', 'slug' => 'parfum-wewangian'],
  ['icon' => '9.png', 'label' => 'Perawatan Rambut', 'slug' => 'perawatan-rambut'],
  ['icon' => '10.png', 'label' => 'Loungewear & Piyama', 'slug' => 'loungewear-piyama'],
];

      ?>
      <?php foreach ($kategori as $k): ?>
  <a href="<?= base_url('produk/kategori/' . $k['slug']) ?>" class="text-decoration-none text-dark">
    <div class="item text-center">
      <div class="kategori-icon-wrapper mx-auto mb-2">
        <img src="<?= base_url('assets/frontend/images/category/' . $k['icon']) ?>" alt="icon">
      </div>
      <p class="small fw-semibold mb-0"><?= esc($k['label']) ?></p>
    </div>
  </a>
<?php endforeach ?>

</section>
<!-- Produk Terlaris -->
 <style>
  .product-card {
    transition: all 0.3s ease-in-out;
  }

  .product-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 24px rgba(255, 0, 0, 0.1);
  }

  .product-card img {
    transition: transform 0.3s ease-in-out;
  }

  .product-card:hover img {
    transform: scale(1.05);
  }
</style>

<section class="py-5 bg-light" id="produk">
  <div class="container">
    <h2 class="text-center mb-4">Produk Terlaris</h2>
    <div class="row g-4">
      <?php foreach ($bestSellers as $p): ?>
        <div class="col-6 col-md-3">
          <div class="card h-100 shadow-sm border-0 product-card">
            <div class="overflow-hidden rounded-top" style="height: 250px;">
              <img src="<?= base_url('uploads/' . $p['image']) ?>" class="card-img-top h-100 w-100 object-fit-cover" alt="<?= esc($p['name']) ?>">
            </div>
            <div class="card-body text-center">
              <p class="card-title fw-bold mb-1"><?= esc($p['name']) ?></p>
              <p class="text-danger fw-bold">Rp <?= number_format($p['price'], 0, ',', '.') ?></p>
              <a href="<?= base_url('produk/' . $p['slug']) ?>" class="btn btn-sm btn-outline-danger">Detail</a>
            </div>
          </div>
        </div>
      <?php endforeach ?>
    </div>

    <div class="text-center mt-4">
      <a href="<?= base_url('produk') ?>" class="btn btn-danger px-4 py-2">Lihat Semua Produk</a>
    </div>
  </div>
</section>

<!-- Fitur Unggulan -->
<style>
  .feature-card {
    transition: all 0.3s ease-in-out;
  }
  .feature-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 20px rgba(255, 0, 0, 0.15);
    background-color: #fff0f0; /* merah lembut */
  }
</style>

<section class="py-5 border-top bg-light">
  <div class="container">
    <div class="row text-center g-4">
      <div class="col-md-3">
        <div class="p-4 bg-white rounded-4 shadow-sm h-100 feature-card">
          <i class="bi bi-truck fs-1 text-danger"></i>
          <h6 class="mt-3 fw-bold text-dark">Free Shipping</h6>
          <p class="text-muted small">Gratis ongkir ke seluruh Indonesia tanpa minimum belanja.</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="p-4 bg-white rounded-4 shadow-sm h-100 feature-card">
          <i class="bi bi-cash-coin fs-1 text-danger"></i>
          <h6 class="mt-3 fw-bold text-dark">Money Back Guarantee</h6>
          <p class="text-muted small">Uang kembali 100% jika barang tidak sesuai atau rusak.</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="p-4 bg-white rounded-4 shadow-sm h-100 feature-card">
          <i class="bi bi-shield-lock fs-1 text-danger"></i>
          <h6 class="mt-3 fw-bold text-dark">Secure Checkout</h6>
          <p class="text-muted small">Pembayaran aman dengan enkripsi dan metode terpercaya.</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="p-4 bg-white rounded-4 shadow-sm h-100 feature-card">
          <i class="bi bi-headset fs-1 text-danger"></i>
          <h6 class="mt-3 fw-bold text-dark">24/7 Support</h6>
          <p class="text-muted small">Tim kami siap membantu kapan pun Anda butuh bantuan.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<?= $this->endSection() ?>
