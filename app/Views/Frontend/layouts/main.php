<!-- File: Views/Frontend/layouts/main.php -->
<!DOCTYPE html>
<html lang="id">
<head>
  <?= $this->include('Frontend/layouts/head') ?>
</head>
<body>
  <?= $this->include('Frontend/layouts/header') ?>
  <?= $this->renderSection('content') ?>
  <?= $this->include('Frontend/layouts/footer') ?>
  <?= $this->include('Frontend/layouts/scripts') ?>
</body>
</html>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
