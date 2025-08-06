<?= $this->extend('Frontend/layouts/main') ?>
<?= $this->section('content') ?>

<div class="container my-5">
    <h2 id="category-title">Produk Kategori</h2>
    <div id="product-list" class="row mt-4"></div>
</div>

<script>
const params = new URLSearchParams(window.location.search);
const categoryId = params.get('id'); // pastikan URL: ?id=...

fetch(`/api/products?category_id=${categoryId}`)
    .then(res => res.json())
    .then(data => {
        const container = document.getElementById('product-list');
        const title = document.getElementById('category-title');
        container.innerHTML = '';

        if (data.products.length === 0) {
            container.innerHTML = '<p>Tidak ada produk dalam kategori ini.</p>';
            return;
        }

        data.products.forEach(product => {
            const card = `
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="/uploads/${product.image ?? 'default.png'}" class="card-img-top" alt="${product.name}">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">${product.name}</h5>
                            <p class="card-text text-primary">Rp${Number(product.price).toLocaleString('id-ID')}</p>
                            <a href="/produk/${product.slug}" class="btn btn-sm btn-outline-primary mt-auto">Detail</a>
                        </div>
                    </div>
                </div>
            `;
            container.innerHTML += card;
        });

        title.innerText = `Produk Kategori: ${data.products[0].category_name}`;
    })
    .catch(err => {
        console.error(err);
        document.getElementById('product-list').innerHTML = '<p>Gagal memuat produk.</p>';
    });
</script>

<?= $this->endSection() ?>
