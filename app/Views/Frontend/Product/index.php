<?= $this->extend('Frontend/layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-5">

  <!-- Filter & Sort -->
  <form id="filter-form" class="d-flex flex-wrap align-items-center justify-content-between mb-4 gap-3">
    <div class="d-flex flex-wrap gap-3">
      <select id="category" class="form-select shadow-sm" style="min-width:200px">
        <option value="">Semua Kategori</option>
        <?php foreach ($categories as $c): ?>
          <option value="<?= $c['id'] ?>"><?= esc($c['name']) ?></option>
        <?php endforeach ?>
      </select>

      <select id="sort" class="form-select shadow-sm" style="min-width:200px">
        <option value="">Sortir</option>
        <option value="price_asc">Harga Termurah</option>
        <option value="price_desc">Harga Termahal</option>
      </select>
    </div>

    <input type="hidden" id="view" value="grid">
    <button type="submit" class="btn btn-dark rounded-pill px-4">Terapkan</button>
  </form>

  <!-- Toggle View -->
  <div class="d-flex justify-content-end mb-4">
    <button id="grid-view" class="btn btn-outline-dark me-2 rounded-pill active"><i class="bi bi-grid"></i></button>
    <button id="list-view" class="btn btn-outline-dark rounded-pill"><i class="bi bi-list"></i></button>
  </div>

  <!-- Produk -->
  <div id="product-list" class="row g-4">
    <!-- JS inject here -->
  </div>

</div>

<script>
const productList = document.getElementById('product-list');
const filterForm = document.getElementById('filter-form');
const categorySelect = document.getElementById('category');
const sortSelect = document.getElementById('sort');
const viewInput = document.getElementById('view');
const gridBtn = document.getElementById('grid-view');
const listBtn = document.getElementById('list-view');

// Ambil data dari API
async function fetchProducts() {
  const category = categorySelect.value;
  const sort = sortSelect.value;
  const view = viewInput.value;

  let url = `/api/products`;
  const params = new URLSearchParams();
  if (category) params.append('category', category);
  if (sort) params.append('sort', sort);
  url += '?' + params.toString();

  const res = await fetch(url);
  const data = await res.json();

  renderProducts(data.products, view);
}

// Render produk
function renderProducts(products, view) {
  productList.innerHTML = '';
  productList.className = view === 'grid' ? 'row g-4' : 'list-group';

  products.forEach(p => {
    const stars = Array.from({ length: 5 }).map((_, i) =>
      `<i class="bi ${i < p.rating ? 'bi-star-fill' : 'bi-star'}"></i>`
    ).join('');

    if (view === 'grid') {
      productList.innerHTML += `
        <div class="col-6 col-md-3">
          <div class="card border-0 shadow-sm position-relative product-card h-100">
            <a href="/produk/${p.slug}" class="text-decoration-none text-dark">
              <div class="product-img-wrapper position-relative overflow-hidden">
                <img src="/uploads/${p.image}" class="card-img-top product-img" alt="${p.name}">
                ${p.is_best_seller ? '<span class="badge bg-danger position-absolute top-0 start-0 m-2">Terlaris</span>' : ''}
                <div class="product-overlay d-flex justify-content-center align-items-center gap-2">
                  <a href="/wishlist/add/${p.id}" class="btn btn-sm btn-light rounded-circle shadow"><i class="bi bi-heart"></i></a>
                  <a href="/cart/add/${p.id}" class="btn btn-sm btn-light rounded-circle shadow"><i class="bi bi-cart"></i></a>
                </div>
              </div>
            </a>
            <div class="card-body text-center px-2 pb-3">
              <a href="/produk/${p.slug}" class="text-dark text-decoration-none">
                <h6 class="fw-semibold text-truncate mb-1">${p.name}</h6>
              </a>
              <p class="text-danger fw-bold mb-1">Rp ${Number(p.price).toLocaleString('id-ID')}</p>
              <div class="text-warning small">${stars}</div>
            </div>
          </div>
        </div>
      `;
    } else {
      productList.innerHTML += `
        <div class="list-group-item list-group-item-action border-0 shadow-sm d-flex gap-3 mb-3 p-3 align-items-center">
          <img src="/uploads/${p.image}" width="100" height="100" class="rounded object-fit-cover" alt="${p.name}">
          <div class="flex-grow-1">
            <a href="/produk/${p.slug}" class="text-decoration-none text-dark">
              <h6 class="fw-bold mb-1">${p.name}</h6>
            </a>
            <p class="text-danger mb-1">Rp ${Number(p.price).toLocaleString('id-ID')}</p>
            <div class="text-warning small">${stars}</div>
          </div>
          <div class="d-flex gap-2">
            <a href="/wishlist/add/${p.id}" class="btn btn-sm btn-outline-danger rounded-circle">
              <i class="bi bi-heart"></i>
            </a>
            <a href="/cart/add/${p.id}" class="btn btn-sm btn-outline-dark rounded-circle">
              <i class="bi bi-cart"></i>
            </a>
          </div>
        </div>
      `;
    }
  });
}

// Event listener
filterForm.addEventListener('submit', e => {
  e.preventDefault();
  fetchProducts();
});

gridBtn.addEventListener('click', () => {
  viewInput.value = 'grid';
  gridBtn.classList.add('active');
  listBtn.classList.remove('active');
  fetchProducts();
});

listBtn.addEventListener('click', () => {
  viewInput.value = 'list';
  listBtn.classList.add('active');
  gridBtn.classList.remove('active');
  fetchProducts();
});

// Load awal
fetchProducts();
</script>

<?= $this->endSection() ?>
