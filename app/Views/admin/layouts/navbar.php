<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
  <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
    <a class="nav-item nav-link px-0 me-xl-4" href="#">
      <i class="bx bx-menu bx-sm"></i>
    </a>
  </div>

  <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
    <ul class="navbar-nav flex-row align-items-center ms-auto">

      <!-- 🔔 Notifikasi Pesanan Baru -->
      <li class="nav-item">
  <a class="nav-link" href="<?= base_url('admin/pesanan?status=pending') ?>">
    <i class="bx bx-bell"></i>
    <span id="notif-badge" class="badge bg-danger rounded-pill <?= empty($newOrderCount) ? 'd-none' : '' ?>">
      <?= $newOrderCount ?>
    </span>
  </a>
</li>
<!-- 🔔 Notifikasi Kontak Masuk -->
<li class="nav-item">
  <a class="nav-link" href="<?= base_url('admin/kontak') ?>">
    <i class="bx bx-envelope"></i>
    <span id="notif-contact" class="badge bg-warning rounded-pill <?= empty($newContactCount) ? 'd-none' : '' ?>">
      <?= $newContactCount ?>
    </span>
  </a>
</li>

<script>
  setInterval(() => {
    fetch("<?= base_url('admin/kontak/unread-count') ?>")
      .then(res => res.json())
      .then(data => {
        const badge = document.getElementById("notif-contact");
        if (data.count > 0) {
          badge.textContent = data.count;
          badge.classList.remove("d-none");
        } else {
          badge.classList.add("d-none");
        }
      });
  }, 10000);
</script>

<script>
  setInterval(() => {
    fetch("<?= base_url('api/orders/pending-count') ?>")
      .then(response => response.json())
      .then(data => {
        const badge = document.getElementById("notif-badge");
        if (data.count > 0) {
          badge.textContent = data.count;
          badge.classList.remove("d-none");
        } else {
          badge.classList.add("d-none");
        }
      })
      .catch(error => console.error("Polling error:", error));
  }, 10000); // 10 detik
</script>
<?php
$logo = get_setting('site_logo');
$logoPath = $logo && file_exists(FCPATH . 'uploads/' . $logo)
    ? base_url('uploads/' . $logo)
    : base_url('assets/img/default-logo.png'); // fallback logo default
?>
<!-- 👤 User -->
<li class="nav-item navbar-dropdown dropdown-user dropdown">
  <a class="nav-link dropdown-toggle hide-arrow" href="#" data-bs-toggle="dropdown" aria-label="User menu">
    <div class="avatar avatar-online">
      <img
        src="<?= esc($logoPath) ?>"
        alt="Logo Toko"
        class="rounded-circle"
        style="width: 40px; height: 40px; object-fit: cover;"
        onerror="this.onerror=null; this.src='<?= base_url('assets/img/default-logo.png') ?>';"
      />
    </div>
  </a>
  <ul class="dropdown-menu dropdown-menu-end">
    <li>
     <a class="dropdown-item" href="<?= base_url('admin/logout') ?>">
  <i class="bx bx-log-out me-2"></i> Logout
</a>

    </li>
  </ul>
</li>



    </ul>
  </div>
</nav>
<style>
  .position-relative .badge {
    font-size: 0.65rem;
    padding: 3px 6px;
  }
</style>
