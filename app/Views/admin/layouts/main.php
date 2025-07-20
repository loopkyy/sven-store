<!DOCTYPE html>
<html lang="en" class="customizer-hide" dir="ltr" data-assets-path="<?= base_url('assets/admin/') ?>" data-template="vertical-menu-template-no-customizer">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
  <title><?= get_setting('site_name') ?? 'E-Commerce' ?></title>
  <link rel="icon" href="<?= base_url('uploads/' . get_setting('site_favicon')) ?>" type="image/x-icon">

  <!-- Font & Icons -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="<?= base_url('assets/admin/vendor/css/core.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/admin/vendor/css/theme-default.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/admin/css/demo.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') ?>" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script src="<?= base_url('assets/admin/vendor/js/helpers.js') ?>"></script>
  <?= $this->renderSection('styles') ?>
</head>
<body>
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <?= $this->include('admin/layouts/sidebar') ?>

      <div class="layout-page">
        <?= $this->include('admin/layouts/navbar') ?>
        <div class="content-wrapper">
          <div class="container-xxl flex-grow-1 container-p-y">
            <?= $this->renderSection('content') ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Core JS -->
  <script src="<?= base_url('assets/admin/vendor/libs/jquery/jquery.js') ?>"></script>
  <script src="<?= base_url('assets/admin/vendor/js/bootstrap.js') ?>"></script>
  <script src="<?= base_url('assets/admin/vendor/js/menu.js') ?>"></script>
  <script src="<?= base_url('assets/admin/js/main.js') ?>"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <script>
    document.querySelectorAll('.format-rupiah').forEach(input => {
      input.addEventListener('input', function (e) {
        let angka = this.value.replace(/[^,\d]/g, '').toString();
        let split = angka.split(',');
        let sisa = split[0].length % 3;
        let rupiah = split[0].substr(0, sisa);
        let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
          let separator = sisa ? '.' : '';
          rupiah += separator + ribuan.join('.');
        }

        this.value = 'Rp' + rupiah;
      });
    });
  </script>

  <?= $this->renderSection('scripts') ?>
</body>
</html>
