<?= $this->extend('Frontend/layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-5">

  <!-- Filter & Sort Form -->
  <form method="get" class="d-flex flex-wrap align-items-center justify-content-between mb-4 gap-3">
    <div class="d-flex flex-wrap gap-3">
      <select name="category" class="form-select shadow-sm" style="min-width:200px">
        <option value="">Semua Kategori</option>
        <?php foreach ($categories as $c): ?>
          <option value="<?= $c['id'] ?>" <?= ($selected_category == $c['id']) ? 'selected' : '' ?>>
            <?= esc($c['name']) ?>
          </option>
        <?php endforeach ?>
      </select>

      <select name="sort" class="form-select shadow-sm" style="min-width:200px">
        <option value="">Sortir</option>
        <option value="price_asc" <?= $selected_sort == 'price_asc' ? 'selected' : '' ?>>Harga Termurah</option>
        <option value="price_desc" <?= $selected_sort == 'price_desc' ? 'selected' : '' ?>>Harga Termahal</option>
      </select>
    </div>

    <input type="hidden" name="view" value="<?= $selected_view ?>">
    <button class="btn btn-dark rounded-pill px-4" type="submit">Terapkan</button>
  </form>

  <!-- Toggle Tampilan -->
  <div class="d-flex justify-content-end mb-4">
    <a href="?<?= http_build_query(array_merge($_GET, ['view' => 'grid'])) ?>"
       class="btn btn-outline-dark me-2 rounded-pill <?= $selected_view == 'grid' ? 'active' : '' ?>">
      <i class="bi bi-grid"></i>
    </a>
    <a href="?<?= http_build_query(array_merge($_GET, ['view' => 'list'])) ?>"
       class="btn btn-outline-dark rounded-pill <?= $selected_view == 'list' ? 'active' : '' ?>">
      <i class="bi bi-list"></i>
    </a>
  </div>

  <!-- Produk -->
  <div class="<?= $selected_view == 'grid' ? 'row g-4' : 'list-group' ?>">
    <?php foreach ($products as $p): ?>
      <?php if ($selected_view == 'grid'): ?>
        <div class="col-6 col-md-3">
          <div class="card border-0 shadow-sm position-relative product-card h-100">

            <a href="<?= base_url('produk/' . $p['slug']) ?>" class="text-decoration-none text-dark">
              <div class="product-img-wrapper position-relative overflow-hidden">
                <img src="<?= base_url('uploads/' . $p['image']) ?>" class="card-img-top product-img" alt="<?= esc($p['name']) ?>">

                <?php if (!empty($p['is_best_seller'])): ?>
                  <span class="badge bg-danger position-absolute top-0 start-0 m-2">Terlaris</span>
                <?php endif ?>

                <div class="product-overlay d-flex justify-content-center align-items-center gap-2">
                  <a href="<?= base_url('wishlist/add/' . $p['id']) ?>" class="btn btn-sm btn-light rounded-circle shadow" onclick="event.stopPropagation();"><i class="bi bi-heart"></i></a>
                  <a href="<?= base_url('cart/add/' . $p['id']) ?>" class="btn btn-sm btn-light rounded-circle shadow" onclick="event.stopPropagation();"><i class="bi bi-cart"></i></a>
                </div>
              </div>
            </a>

            <div class="card-body text-center px-2 pb-3">
              <a href="<?= base_url('produk/' . $p['slug']) ?>" class="text-dark text-decoration-none">
                <h6 class="fw-semibold text-truncate mb-1"><?= esc($p['name']) ?></h6>
              </a>
              <p class="text-danger fw-bold mb-1">Rp <?= number_format($p['price'], 0, ',', '.') ?></p>
              <div class="text-warning small">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                  <i class="bi <?= $i <= $p['rating'] ? 'bi-star-fill' : 'bi-star' ?>"></i>
                <?php endfor ?>
              </div>
            </div>

          </div>
        </div>
      <?php else: ?>
        <!-- List View -->
        <div class="list-group-item list-group-item-action border-0 shadow-sm d-flex gap-3 mb-3 p-3 align-items-center">
          <img src="<?= base_url('uploads/' . $p['image']) ?>" width="100" height="100" class="rounded object-fit-cover" alt="<?= esc($p['name']) ?>">
          <div class="flex-grow-1">
            <a href="<?= base_url('produk/' . $p['slug']) ?>" class="text-decoration-none text-dark">
              <h6 class="fw-bold mb-1"><?= esc($p['name']) ?></h6>
            </a>
            <p class="text-danger mb-1">Rp <?= number_format($p['price'], 0, ',', '.') ?></p>
            <div class="text-warning small">
              <?php for ($i = 1; $i <= 5; $i++): ?>
                <i class="bi <?= $i <= $p['rating'] ? 'bi-star-fill' : 'bi-star' ?>"></i>
              <?php endfor ?>
            </div>
          </div>
<div class="d-flex gap-2">
    <a href="<?= base_url('wishlist/add/' . $p['id']) ?>" class="btn btn-sm btn-outline-danger rounded-circle">
        <i class="bi bi-heart"></i>
    </a>
    <a href="<?= base_url('cart/add/' . $p['id']) ?>" class="btn btn-sm btn-outline-dark rounded-circle">
        <i class="bi bi-cart"></i>
    </a>
</div>

        </div>
      <?php endif ?>
    <?php endforeach ?>
  </div>

</div>
<!-- Pagination -->
<div class="mt-4">
  <?= $pager->links('product', 'bootstrap') ?>
</div>

<!-- Styling -->
<style>
  .btn.active {
    background-color: #000;
    color: #fff;
    border-color: #000;
  }

  .product-img {
    height: 220px;
    object-fit: cover;
    border-radius: .75rem .75rem 0 0;
    transition: transform 0.3s ease;
  }

  .product-card:hover .product-img {
    transform: scale(1.05);
  }

  .product-img-wrapper {
    position: relative;
  }

  .product-overlay {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    opacity: 0;
    background-color: rgba(255, 255, 255, 0.6);
    transition: all 0.3s ease;
    border-radius: .75rem .75rem 0 0;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
  }

  .product-card:hover .product-overlay {
    opacity: 1;
  }

  .product-overlay a {
    opacity: 0;
    transform: translateY(10px);
    transition: all 0.3s ease;
  }

  .product-card:hover .product-overlay a {
    opacity: 1;
    transform: translateY(0);
  }

  .product-overlay a:hover {
    background-color: #dc3545;
    color: #fff;
    border-color: transparent;
  }

  .product-overlay .btn {
    width: 40px;
    height: 40px;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .product-overlay .btn.btn-sm {
    width: 36px;
    height: 36px;
    padding: 0;
    font-size: 14px;
  }

  .text-truncate {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .object-fit-cover {
    object-fit: cover;
  }
</style>

<?= $this->endSection() ?>
