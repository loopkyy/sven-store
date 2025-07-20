<?php
$uri = service('uri');
$role = session('user.role') ?? 'guest';
?>

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="<?= base_url('/') ?>" class="app-brand-link">
      <span class="app-brand-text demo menu-text fw-bold ms-2">
        Lunaya<span class="glow-moon">🌙</span>
      </span>
    </a>
  </div>
<style>
  .glow-moon {
    display: inline-block;
    margin-left: 3px;
    color: #ffd43b;
    text-shadow:
      0 0 4px #ffe066,
      0 0 8px #ffd43b,
      0 0 12px #fab005,
      0 0 16px #f59f00;
    animation: glow 2s ease-in-out infinite alternate;
  }

  @keyframes glow {
    from {
      text-shadow:
        0 0 4px #ffe066,
        0 0 8px #ffd43b,
        0 0 12px #fab005,
        0 0 16px #f59f00;
    }
    to {
      text-shadow:
        0 0 6px #ffe066,
        0 0 10px #ffd43b,
        0 0 16px #fab005,
        0 0 22px #f59f00;
    }
  }
</style>


  <ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item <?= $uri->getSegment(1) == '' ? 'active' : '' ?>">
      <a href="<?= base_url('/') ?>" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div>Dashboard</div>
      </a>
    </li>

    <?php if ($role === 'superadmin'): ?>
      <!-- Menu untuk Superadmin Saja -->
      <li class="menu-item <?= $uri->getSegment(1) == 'admin' ? 'active' : '' ?>">
        <a href="<?= base_url('/superadmin') ?>" class="menu-link">
          <i class="menu-icon tf-icons bx bx-user-check"></i>
          <div>Kelola Admin</div>
        </a>
      </li>

      <li class="menu-item <?= $uri->getSegment(1) == 'log' ? 'active' : '' ?>">
  <a href="<?= base_url('superadmin/log') ?>" class="menu-link">
    <i class="menu-icon tf-icons bx bx-history"></i>
    <div>Log Aktivitas</div>
  </a>
</li>


      <li class="menu-item <?= $uri->getSegment(1) == 'pengaturan' ? 'active' : '' ?>">
        <a href="<?= base_url('superadmin/pengaturan') ?>" class="menu-link">
          <i class="menu-icon tf-icons bx bx-cog"></i>
          <div>Pengaturan</div>
        </a>
      </li>

    <?php else: ?>
      <!-- Menu untuk Admin Biasa -->
      <li class="menu-item <?= $uri->getSegment(1) == 'produk' ? 'active' : '' ?>">
        <a href="<?= base_url('admin/produk') ?>" class="menu-link">
          <i class="menu-icon tf-icons bx bx-package"></i>
          <div>Produk</div>
        </a>
      </li>

      <li class="menu-item <?= $uri->getSegment(1) == 'kategori' ? 'active' : '' ?>">
        <a href="<?= base_url('admin/kategori') ?>" class="menu-link">
          <i class="menu-icon tf-icons bx bx-category"></i>
          <div>Kategori</div>
        </a>
      </li>

      <li class="menu-item <?= $uri->getSegment(1) == 'pesanan' ? 'active' : '' ?>">
        <a href="<?= base_url('admin/pesanan') ?>" class="menu-link">
          <i class="menu-icon tf-icons bx bx-cart"></i>
          <div>Pesanan</div>
        </a>
      </li>

      <li class="menu-item <?= $uri->getSegment(1) == 'restok' ? 'active' : '' ?>">
        <a href="<?= base_url('admin/restok') ?>" class="menu-link">
          <i class="menu-icon tf-icons bx bx-plus-circle"></i>
          <div>Restok</div>
        </a>
      </li>

      <li class="menu-item <?= $uri->getSegment(1) == 'retur' ? 'active' : '' ?>">
        <a href="<?= base_url('admin/retur') ?>" class="menu-link">
          <i class="menu-icon tf-icons bx bx-undo"></i>
          <div>Retur</div>
        </a>
      </li>

      <li class="menu-item <?= $uri->getSegment(1) == 'kupon' ? 'active' : '' ?>">
        <a href="<?= base_url('admin/kupon') ?>" class="menu-link">
          <i class="menu-icon tf-icons bx bx-gift"></i>
          <div>Kupon</div>
        </a>
      </li>

      <li class="menu-item <?= $uri->getSegment(1) == 'pembayaran' ? 'active' : '' ?>">
        <a href="<?= base_url('admin/pembayaran') ?>" class="menu-link">
          <i class="menu-icon tf-icons bx bx-credit-card-alt"></i>
          <div>Pembayaran</div>
        </a>
      </li>

      <li class="menu-item <?= $uri->getSegment(1) == 'laporan' ? 'active' : '' ?>">
        <a href="<?= base_url('admin/laporan') ?>" class="menu-link">
          <i class="menu-icon tf-icons bx bx-bar-chart"></i>
          <div>Laporan</div>
        </a>
      </li>

      <li class="menu-item <?= $uri->getSegment(1) == 'pelanggan' ? 'active' : '' ?>">
        <a href="<?= base_url('admin/pelanggan') ?>" class="menu-link">
          <i class="menu-icon tf-icons bx bx-user"></i>
          <div>Pelanggan</div>
        </a>
      </li>

      <li class="menu-item <?= $uri->getSegment(1) == 'newsletter' ? 'active' : '' ?>">
        <a href="<?= base_url('admin/newsletter') ?>" class="menu-link">
          <i class="menu-icon tf-icons bx bx-envelope"></i>
          <div>Newsletter</div>
        </a>
      </li>
    <?php endif; ?>
  </ul>
</aside>
