<body>
    <!-- Header Section Start -->
    <header class="pt-3 border-bottom">

        <!-- Navbar -->
            <!-- Tambahkan ini ke elemen navbar atau header -->


            <div class="container">
                <div class="row">
                    <div class="col-lg-2 mb-3 d-flex justify-content-between pt-3 pt-lg-0 pb-2 pb-lg-0">
                        <div class="list-inline-item d-inline-block d-lg-none">
                            <button class="navbar-toggler border-0 collapsed" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#navbar-default" aria-controls="navbar-default"
                                aria-label="Toggle navigation">
                                <i class="bi bi-text-indent-left"></i>
                        </div>
                        <!-- Logo -->
                        <a class="navbar-brand flex-shrink-0" href="index.html" style="padding: 0;">
  <img 
    src="<?= base_url('assets/frontend/images/haha.png') ?>" 
    alt="Lunaya" 
    style="height: 72px !important; width: auto; display: block; max-height: none;">
</a>

                        <!-- Logo -->
                        <div class="list-inline  d-flex d-lg-none">
                            <div class="list-inline-item me-4">
                                <a href="login.html"
                                    class="text-muted d-flex flex-column justity-content-center align-items-center">
                                    <i class="bi bi-person"></i>
                                    <span class="d-block" style="font-size: 10px;">Account</span>
                                </a>
                            </div>
                            <div class="list-inline-item me-4">
                                <a href="cart.html"
                                    class="text-muted  d-flex flex-column justity-content-center align-items-center">
                                    <div class="position-relative">
                                        <i class="bi bi-cart"></i>
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
                                            5
                                        </span>
                                    </div>
                                    <span class="d-block" style="font-size: 10px;">Your cart</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <!-- Search -->
                        <form method="get" action="<?= base_url('produk') ?>">
  <div class="input-group mb-3">
    <span class="input-group-text bg-danger text-white">
      <i class="bi bi-search"></i>
    </span>
    <input type="text" class="form-control py-2" name="search" placeholder="Cari produk..." aria-label="Search">
  </div>
</form>

                        <!-- Search -->
                    </div>
                    <div class="col-lg-3 d-none d-lg-block">
                        <!-- Navbar Actions -->
<?php
$cart_total = session()->get('cart_total') ?? 0;
$is_cart_active = $cart_total > 0 ? 'text-danger' : 'text-muted';
$badge_color = $cart_total > 0 ? 'bg-danger' : 'bg-secondary';
?>
<!-- Account -->
<div class="list-inline-item me-4">
  <?php if (session()->get('isLoggedIn')): ?>
    <div class="dropdown">
      <a class="text-muted d-flex flex-column align-items-center dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-person fs-5"></i>
        <span class="d-block" style="font-size: 10px;"><?= esc(session()->get('user_name')) ?></span>
      </a>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="<?= base_url('akun') ?>">Akun Saya</a></li>
        <li><a class="dropdown-item" href="<?= base_url('checkout') ?>">Checkout</a></li>
      </ul>
    </div>
  <?php else: ?>
    <a href="<?= base_url('login') ?>" class="text-muted d-flex flex-column align-items-center">
      <i class="bi bi-person fs-5"></i>
      <span class="d-block" style="font-size: 10px;">Sign In</span>
    </a>
  <?php endif; ?>
</div>

<!-- Wishlist -->
<div class="list-inline-item me-4">
  <a href="<?= base_url('wishlist') ?>" class="text-muted d-flex flex-column justify-content-center align-items-center">
    <div class="position-relative">
      <i class="bi bi-heart fs-5"></i>
      <?php if (!empty($wishlist_count)): ?>
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger text-white fw-semibold px-2">
          <?= $wishlist_count ?>
        </span>
      <?php endif; ?>
    </div>
    <span class="d-block" style="font-size: 10px;">Wishlist</span>
  </a>
</div>

<!-- Cart -->
<div class="list-inline-item me-4">
  <a href="<?= base_url('cart') ?>" class="<?= $is_cart_active ?> d-flex flex-column justify-content-center align-items-center">
    <div class="position-relative">
      <i class="bi bi-cart fs-5"></i>
      <?php if ($cart_total > 0): ?>
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill <?= $badge_color ?> text-white fw-semibold px-2">
          <?= $cart_total ?>
        </span>
      <?php endif; ?>
    </div>
    <span class="d-block" style="font-size: 10px;">Your Cart</span>
  </a>
</div>

                        <!-- Navbar Actions -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Navbar -->
        <!-- Navs -->
        <nav class="navbar navbar-expand-lg navbar-light navbar-default py-0 pb-lg-2 border border-start-0 border-end-0"
            aria-label="Offcanvas navbar large">
            <div class="container">
                <div class="offcanvas offcanvas-start pt-2" tabindex="-1" id="navbar-default"
                    aria-labelledby="navbar-defaultLabel">
                    <div class="offcanvas-header pb-1">
                        <a href="index.html"><img src="./assets/images/logo.png" alt="eCommerce HTML Template"></a>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">

<div class="d-block d-lg-none mb-4">
  <a class="btn btn-primary w-100 d-flex justify-content-center align-items-center collapsed"
     data-bs-toggle="collapse" href="#collapseKategori" role="button" aria-expanded="false"
     aria-controls="collapseKategori">
    <span class="me-2">
      <i class="bi bi-grid"></i>
    </span>
    Semua Kategori
  </a>
  <div class="mt-2 collapse" id="collapseKategori">
    <div class="card card-body">
      <ul class="mb-0 list-unstyled">
        <li><a class="dropdown-item" href="<?= base_url('produk/kategori/pakaian-wanita') ?>"><i class="bi bi-person-fill me-2"></i> Pakaian Wanita</a></li>
        <li><a class="dropdown-item" href="<?= base_url('produk/kategori/pakaian-pria') ?>"><i class="bi bi-people-fill me-2"></i> Pakaian Pria</a></li>
        <li><a class="dropdown-item" href="<?= base_url('produk/kategori/tas-dompet') ?>"><i class="bi bi-handbag me-2"></i> Tas & Dompet</a></li>
        <li><a class="dropdown-item" href="<?= base_url('produk/kategori/sepatu-sandal') ?>"><i class="bi bi-basket me-2"></i> Sepatu & Sandal</a></li>
        <li><a class="dropdown-item" href="<?= base_url('produk/kategori/aksesori-fashion') ?>"><i class="bi bi-star-fill me-2"></i> Aksesori Fashion</a></li>
        <li><a class="dropdown-item" href="<?= base_url('produk/kategori/skincare-bodycare') ?>"><i class="bi bi-droplet-half me-2"></i> Skincare & Bodycare</a></li>
        <li><a class="dropdown-item" href="<?= base_url('produk/kategori/kosmetik-makeup') ?>"><i class="bi bi-brush me-2"></i> Kosmetik & Makeup</a></li>
        <li><a class="dropdown-item" href="<?= base_url('produk/kategori/parfum-wewangian') ?>"><i class="bi bi-flower1 me-2"></i> Parfum & Wewangian</a></li>
        <li><a class="dropdown-item" href="<?= base_url('produk/kategori/perawatan-rambut') ?>"><i class="bi bi-scissors me-2"></i> Perawatan Rambut</a></li>
        <li><a class="dropdown-item" href="<?= base_url('produk/kategori/loungewear-piyama') ?>"><i class="bi bi-moon-stars me-2"></i> Loungewear & Piyama</a></li>
      </ul>
    </div>
  </div>
</div>


<!-- DESKTOP: Dropdown All Categories -->
<div class="dropdown me-3 d-none d-lg-block">
  <button class="btn  px-6" type="button" id="dropdownMenuKategori" data-bs-toggle="dropdown"
    aria-expanded="false">
    <span class="me-1">
      <i class="bi bi-grid"></i>
    </span>
    Semua Kategori
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenuKategori">
<li><a class="dropdown-item" href="<?= base_url('produk/kategori/pakaian-wanita') ?>"><i class="bi bi-person-fill me-2"></i> Pakaian Wanita</a></li>
        <li><a class="dropdown-item" href="<?= base_url('produk/kategori/pakaian-pria') ?>"><i class="bi bi-person me-2"></i> Pakaian Pria</a></li>
        <li><a class="dropdown-item" href="<?= base_url('produk/kategori/tas-dompet') ?>"><i class="bi bi-bag-fill me-2"></i> Tas & Dompet</a></li>
        <li><a class="dropdown-item" href="<?= base_url('produk/kategori/sepatu-sandal') ?>"><i class="bi bi-bootstrap-fill me-2"></i> Sepatu & Sandal</a></li>
        <li><a class="dropdown-item" href="<?= base_url('produk/kategori/aksesori-fashion') ?>"><i class="bi bi-stars me-2"></i> Aksesori Fashion</a></li>
        <li><a class="dropdown-item" href="<?= base_url('produk/kategori/skincare-bodycare') ?>"><i class="bi bi-droplet-half me-2"></i> Skincare & Bodycare</a></li>
        <li><a class="dropdown-item" href="<?= base_url('produk/kategori/kosmetik-makeup') ?>"><i class="bi bi-brush me-2"></i> Kosmetik & Makeup</a></li>
        <li><a class="dropdown-item" href="<?= base_url('produk/kategori/parfum-wewangian') ?>"><i class="bi bi-flower1 me-2"></i> Parfum & Wewangian</a></li>
        <li><a class="dropdown-item" href="<?= base_url('produk/kategori/perawatan-rambut') ?>"><i class="bi bi-scissors me-2"></i> Perawatan Rambut</a></li>
        <li><a class="dropdown-item" href="<?= base_url('produk/kategori/loungewear-piyama') ?>"><i class="bi bi-moon-stars me-2"></i> Loungewear & Piyama</a></li>
  </ul>
</div>
<style>
.nav-link.active {
  color: #dc3545 !important; /* merah */
  font-weight: 600;
  border-bottom: 2px solid #dc3545;
}
</style>

    <div>
  <ul class="navbar-nav align-items-center ms-lg-5">
    <li class="nav-item dropdown w-100 w-lg-auto me-3">
      <a class="nav-link <?= (uri_string() == '' ? 'active fw-semibold text-danger' : '') ?>" 
   href="<?= site_url('/') ?>">
   Home
</a>

    </li>
<li class="nav-item dropdown w-100 w-lg-auto me-3">
  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
    aria-expanded="false">Shop</a>
  <ul class="dropdown-menu">
    <li><a class="dropdown-item" href="<?= base_url('produk') ?>">Semua Produk</a></li>
    <li><a class="dropdown-item" href="<?= base_url('wishlist') ?>">Wishlist</a></li>
    <li><a class="dropdown-item" href="<?= base_url('cart') ?>">Keranjang</a></li>
    <li><a class="dropdown-item" href="<?= base_url('checkout') ?>">Checkout</a></li>
  </ul>
</li>


<li class="nav-item dropdown w-100 w-lg-auto dropdown-fullwidth me-3">
  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Kategori</a>
  <div class="dropdown-menu pb-0">
    <div class="row p-2 p-lg-4">
      <?php
      function to_slug($string) {
        $string = strtolower($string);
        $string = preg_replace('/[^a-z0-9\s-]/', '', $string); // hapus karakter aneh
        $string = preg_replace('/[\s]+/', '-', $string); // spasi ke strip
        return trim($string);
      }

      $kategori = [
        "Pakaian Wanita" => [
          "Zara Basic White Blouse",
          "H&M Floral Midi Dress",
          "Uniqlo Linen Shirt Wanita",
          "Mango Pastel Knit Cardigan",
          "Zalora High Waist Black Culottes"
        ],
        "Pakaian Pria" => [
          "Uniqlo Kemeja Flanel",
          "H&M Hoodie Oversize Grey",
          "Levi’s Denim Jacket",
          "Giordano Polo Shirt",
          "Pull & Bear Celana Chino"
        ],
        "Tas & Dompet" => [
          "Charles & Keith Mini Bag",
          "Eiger Compact Backpack 20L",
          "Pedro Tote Bag Leather",
          "Guess Quilted Wallet",
          "Exsport Slingbag Unisex"
        ],
        "Sepatu & Sandal" => [
          "Nike Court Vision Sneakers",
          "Adidas Grand Court White",
          "Melissa Platform Sandals",
          "Wakai Loafers Casual",
          "Dr. Martens 1460 Boots"
        ],
        "Aksesori Fashion" => [
          "Daniel Wellington Watch Classic",
          "Ray-Ban Wayfarer Sunglasses",
          "Cotton On Scarf Patterned",
          "Herschel Leather Belt",
          "H&M Statement Earrings"
        ],
        "Skincare & Bodycare" => [
          "Scarlett Whitening Serum Niacinamide",
          "Somethinc Glowing Toner",
          "Vaseline Healthy White Lotion 400ml",
          "Emina Sun Battle SPF 45",
          "St. Ives Apricot Scrub"
        ],
        "Kosmetik & Makeup" => [
          "Wardah Everyday Lip Cream",
          "Emina Cushion Bare With Me",
          "Maybelline Hypercurl Mascara",
          "Make Over Ultra Cover Foundation",
          "Implora Lip Tint"
        ],
        "Parfum & Wewangian" => [
          "Zara Femme EDP 30ml",
          "Victoria’s Secret Love Spell Mist",
          "The Body Shop White Musk EDP",
          "Romano Eau de Cologne",
          "Vitalis Roll On Perfume"
        ],
        "Perawatan Rambut" => [
          "Sunsilk Soft & Smooth Shampoo 320ml",
          "Pantene Conditioner Total Damage Care",
          "Ellips Hair Vitamin Pink Box",
          "Makarizo Hair Mask Sachet Box",
          "NR Hair Tonic Original"
        ],
        "Loungewear & Piyama" => [
          "Sorella Piyama Katun Set",
          "Noir Sur Blanc Daster Modern",
          "Minimal Satin Piyama Set",
          "Uniqlo Kaos & Celana Pendek Rumah",
          "H&M Sleepwear Polos Lengan Panjang"
        ]
      ];

      $col = 0;
      foreach ($kategori as $judul => $produk):
        if ($col % 4 === 0): ?><div class="w-100 d-lg-none"></div><?php endif;
      ?>
        <div class="col-lg-3 col-12 mb-4 mb-lg-0">
          <h6 class="text-danger ps-3"><?= esc($judul) ?></h6>
          <?php foreach ($produk as $p): ?>
            <a class="dropdown-item" href="<?= base_url('produk/' . to_slug($p)) ?>"><?= esc($p) ?></a>
          <?php endforeach; ?>
        </div>
      <?php
        $col++;
      endforeach;
      ?>
    </div>
  </div>
</li>

                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <!-- Navs -->
    </header>
    <!-- Header Section End -->
