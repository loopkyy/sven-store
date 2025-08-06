<?= $this->extend('Frontend/layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-5" id="product-detail">
  <div id="loading" class="text-center my-5">Memuat data produk...</div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', async () => {
    const container = document.getElementById('product-detail');
    const loading = document.getElementById('loading');
    const slug = window.location.pathname.split('/').pop(); // ambil slug dari URL

    try {
      const res = await fetch(`/api/products/slug/${slug}`);
      if (!res.ok) throw new Error('Produk tidak ditemukan');
      const product = await res.json();
      loading.remove();

      container.innerHTML = `
        <div class="row g-4">
          <div class="col-md-6">
            <img src="/uploads/${product.image}" class="img-fluid rounded" alt="${product.name}">
          </div>
          <div class="col-md-6">
            <h3 class="fw-bold">${product.name}</h3>
            <p class="text-danger fs-4 fw-bold">Rp ${Number(product.price).toLocaleString('id-ID')}</p>
            <div class="text-warning mb-3">
              ${[1,2,3,4,5].map(i => `<i class="bi ${i <= product.rating ? 'bi-star-fill' : 'bi-star'}"></i>`).join('')}
            </div>
            <p>${product.description}</p>

            <form id="add-to-cart" class="mt-4">
              <input type="hidden" name="product_id" value="${product.id}">
              <div class="mb-3">
                <label for="qty" class="form-label">Jumlah</label>
                <input type="number" name="qty" id="qty" class="form-control" value="1" min="1">
              </div>
              ${product.has_size ? `
              <div class="mb-3">
                <label for="size" class="form-label">Ukuran</label>
                <select name="size" id="size" class="form-select">
                  <option value="S">S</option>
                  <option value="M">M</option>
                  <option value="L">L</option>
                  <option value="XL">XL</option>
                </select>
              </div>` : ''}
              <button type="submit" class="btn btn-dark">+ Keranjang</button>
            </form>
          </div>
        </div>
      `;

      document.getElementById('add-to-cart').addEventListener('submit', async (e) => {
        e.preventDefault();
        const form = e.target;
        const data = {
          product_id: form.product_id.value,
          qty: form.qty.value,
          size: form.size ? form.size.value : null,
        };

        const cartRes = await fetch('/api/cart/add', {
          method: 'POST',
          headers: {'Content-Type': 'application/json'},
          body: JSON.stringify(data)
        });

        const result = await cartRes.json();
        alert(result.message || 'Berhasil ditambahkan ke keranjang!');
      });

    } catch (err) {
      loading.innerHTML = `<div class="alert alert-danger text-center">${err.message}</div>`;
    }
  });
</script>

<?= $this->endSection() ?>
