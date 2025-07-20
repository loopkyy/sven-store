<?= $this->extend('Frontend/layouts/main') ?>
<?= $this->section('content') ?>

<div class="container my-5">
  <h2>Keranjang Belanja</h2>

  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
  <?php endif; ?>

  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
  <?php endif; ?>

  <?php if (empty($cartItems)): ?>
    <p>Keranjang kamu kosong. <a href="<?= base_url('produk') ?>">Yuk belanja sekarang!</a></p>
  <?php else: ?>
    <table class="table">
      <thead>
        <tr>
          <th>Produk</th>
          <th>Harga</th>
          <th>Jumlah</th>
          <th>Total</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php
          $grandTotal = 0;
        ?>
        <?php foreach ($cartItems as $key => $item): ?>
          <?php
            $total = $item['price'] * $item['qty'];
            $grandTotal += $total;
          ?>
          <tr>
            <td>
              <img src="<?= base_url('uploads/' . ($item['image'] ?? 'default.png')) ?>" width="50" alt="<?= esc($item['name'] ?? '') ?>">
              <div><?= esc($item['name'] ?? '-') ?></div>
            </td>
            <td>Rp<?= number_format($item['price'], 0, ',', '.') ?></td>
            <td>
              <form action="<?= base_url('cart/update-quantity/' . urlencode($key)) ?>" method="post" class="d-flex">
                <input type="number" name="qty" value="<?= $item['qty'] ?>" min="1" max="<?= $item['stock'] ?? 99 ?>" class="form-control me-2" style="width: 80px;">
                <button class="btn btn-sm btn-primary me-2">Update</button>
              </form>
            </td>
            <td>Rp<?= number_format($total, 0, ',', '.') ?></td>
            <td>
              <a href="<?= base_url('cart/remove/' . urlencode($key)) ?>" class="btn btn-sm btn-danger mt-1">Hapus</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="3"><strong>Total</strong></td>
          <td><strong>Rp<?= number_format($grandTotal, 0, ',', '.') ?></strong></td>
          <td>
            <a href="<?= base_url('cart/clear') ?>" class="btn btn-warning btn-sm">Kosongkan</a>
            <a href="<?= base_url('checkout') ?>" class="btn btn-success btn-sm ms-2">Checkout</a>
          </td>
        </tr>
      </tfoot>
    </table>
  <?php endif; ?>
</div>

<?= $this->endSection() ?>
