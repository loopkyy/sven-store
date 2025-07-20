<!-- Footer Section -->
<footer class="mt-5 bg-light border-top">
  <div class="container py-5">
    <div class="row gy-4">
      
      <!-- Logo & Deskripsi -->
      <div class="col-md-4">
        <div class="mb-3">
          <img src="<?= base_url('assets/frontend/images/haha.png') ?>" alt="Lunaya Logo" class="logo" style="max-height: 72px;">
        </div>
        <p class="text-muted">
        Lunaya adalah platform eCommerce yang menghadirkan berbagai produk fashion, skincare, dan lifestyle
        terkini. Kami menyediakan koleksi lengkap mulai dari
        pakaian wanita & pria, tas, sepatu, aksesoris, hingga produk kecantikan dan perawatan diri. 
        Dengan harga terjangkau, desain kekinian, dan pelayanan terbaik, Lunaya hadir sebagai solusi belanja modern yang praktis dan menyenangkan.


        </p>
       <div class="d-flex gap-3 mt-3">
  <a href="https://www.instagram.com/ikyyy.kyzu?igsh=MWhneTY0aW9jMXF2dA==" target="_blank" class="text-dark social-icon">
    <i class="bi bi-instagram fs-5"></i>
  </a>
  <a href="https://github.com/loopkyy" target="_blank" class="text-dark social-icon">
    <i class="bi bi-github fs-5"></i>
  </a>
  <a href="https://www.linkedin.com/in/rizky-riaadha-rismandana-472173370/" target="_blank" class="text-dark social-icon">
    <i class="bi bi-linkedin fs-5"></i>
  </a>
</div>

      </div>

      <!-- My Account -->
     <div class="col-md-4">
  <h5 class="fw-semibold">My Account</h5>
  <ul class="list-unstyled">
      <a href="<?= base_url('wishlist') ?>" class="text-muted text-decoration-none">
        <span class="d-inline-block py-1">Wishlist</span>
      </a>
    </li>
    <li>
      <a href="<?= base_url('akun') ?>" class="text-muted text-decoration-none">
        <span class="d-inline-block py-1">Kelola Akun</span>
      </a>
    </li>
  </ul>
</div>

      <!-- Info Kontak -->
      <div class="col-md-4">
        <h5 class="fw-semibold">Kontak Kami</h5>
        <p class="mb-1 text-muted"><i class="bi bi-geo-alt me-2"></i>Jalan Raya Fashion No.88, Jakarta</p>
        <p class="mb-1 text-muted"><i class="bi bi-telephone me-2"></i>(021) 1234-5678</p>
        <p class="mb-3 text-muted"><i class="bi bi-envelope me-2"></i>support@lunaya.com</p>

        <!-- Newsletter -->
        <form action="<?= base_url('newsletter/subscribe') ?>" method="post" class="newsletter-form">
          <div class="input-group">
            <input type="email" name="email" class="form-control" placeholder="Email kamu..." required>
            <button class="btn btn-primary" type="submit">Langganan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="text-center py-3 bg-dark text-white small">
    &copy; <?= date('Y') ?> Lunaya. All rights reserved.
  </div>

  <!-- Scroll to Top -->
  <a href="#" class="scroll-top bg-primary text-white rounded-circle p-2 position-fixed bottom-0 end-0 me-3 mb-3 d-flex align-items-center justify-content-center" style="z-index:999; width:40px; height:40px;">
    <i class="bi bi-chevron-up"></i>
  </a>
</footer>

<!-- Hover Styles -->
<style>
  /* Link Hover */
  .footer a:hover {
    color: #ff5e5e !important;
    text-decoration: underline;
  }

  /* Social Icon Hover */
  .social-icon:hover {
    color: #e91e63 !important;
    transform: scale(1.1);
    transition: all 0.3s ease;
  }

  /* Scroll to Top Hover */
  .scroll-top:hover {
    background-color: #dc3545;
    box-shadow: 0 0 10px rgba(0,0,0,0.2);
    transition: 0.3s;
  }

  /* Input Newsletter Focus */
  .newsletter-form input:focus {
    border-color: #ff5e5e;
    box-shadow: 0 0 0 0.1rem rgba(255,94,94,.25);
    transition: border-color 0.3s, box-shadow 0.3s;
  }

  /* Tombol Newsletter Hover */
  .newsletter-form button:hover {
    background-color: #ff5e5e;
    border-color: #ff5e5e;
    transition: all 0.3s;
  }
 .footer a span:hover {
  color: #ff5e5e;
  text-decoration: underline;
}


</style>
