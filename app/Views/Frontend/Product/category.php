<?= $this->extend('Frontend/layouts/main') ?>
<?= $this->section('content') ?>

<div class="container my-5">
    <h2>Produk Kategori: <?= esc($category['name']) ?></h2>

    <?php if (empty($products)): ?>
        <p>Tidak ada produk di kategori ini.</p>
    <?php else: ?>
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="<?= base_url('uploads/' . ($product['image'] ?? 'default.png')) ?>" class="card-img-top" alt="<?= esc($product['name']) ?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= esc($product['name']) ?></h5>
                            <p class="card-text text-primary">Rp<?= number_format($product['price'], 0, ',', '.') ?></p>
                            <a href="<?= base_url('produk/' . $product['slug']) ?>" class="btn btn-sm btn-outline-primary mt-auto">Detail</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?= $pager->links() ?>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
