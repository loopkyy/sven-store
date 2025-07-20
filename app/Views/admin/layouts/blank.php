<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $title ?? 'Login' ?></title>
  <link rel="stylesheet" href="<?= base_url('assets/admin/vendor/css/core.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/admin/vendor/css/theme-default.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/admin/css/demo.css') ?>" />
</head>
<body>
  <?= $this->renderSection('content') ?>
</body>
</html>
