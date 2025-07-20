<?= $this->extend('frontend/layouts/main') ?>
<?= $this->section('content') ?>

<div class="container my-5">
  <h2 class="mb-4">Checkout</h2>

  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
  <?php endif; ?>

  <form action="<?= base_url('checkout/process') ?>" method="post">
    <div class="row">
      <!-- Kiri: Data Pembeli -->
      <div class="col-lg-6 mb-4">
        <h5>Informasi Pembeli</h5>
        <div class="mb-3">
          <label for="name" class="form-label">Nama Lengkap</label>
          <input type="text" name="name" class="form-control" value="<?= esc(old('name')) ?>" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" name="email" class="form-control" value="<?= esc(old('email')) ?>" required>
        </div>
        <div class="mb-3">
          <label for="phone" class="form-label">No. HP</label>
          <input type="text" name="phone" class="form-control" value="<?= esc(old('phone')) ?>" required>
        </div>
        <div class="mb-3">
          <label for="address" class="form-label">Alamat Lengkap</label>
          <textarea name="address" rows="3" class="form-control" required><?= esc(old('address')) ?></textarea>
        </div>
        <div class="mb-3">
          <label for="note" class="form-label">Catatan (opsional)</label>
          <textarea name="note" rows="2" class="form-control"><?= esc(old('note')) ?></textarea>
        </div>
        <div class="mb-3">
  <label for="coupon_code" class="form-label">Gunakan Kupon</label>
  <select name="coupon_code" class="form-select">
    <option value="">-- Tanpa Kupon --</option>
    <?php foreach ($availableCoupons as $c): ?>
      <option value="<?= esc($c['code']) ?>" <?= old('coupon_code') == $c['code'] ? 'selected' : '' ?>>
        <?= esc($c['code']) ?> (<?= $c['type'] === 'percent' ? $c['value'] . '%' : 'Rp' . number_format($c['value'], 0, ',', '.') ?>)
      </option>
    <?php endforeach; ?>
  </select>
</div>

        <div class="mb-3">
          <label for="payment_method_id" class="form-label">Metode Pembayaran</label>
          <select name="payment_method_id" class="form-select" required>
            <option value="">-- Pilih Metode --</option>
            <?php foreach ($paymentMethods as $method): ?>
              <option value="<?= $method['id'] ?>" <?= old('payment_method_id') == $method['id'] ? 'selected' : '' ?>>
                <?= esc($method['name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <!-- Kanan: Ringkasan Produk -->
      <div class="col-lg-6">
        <h5>Ringkasan Pesanan</h5>
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Produk</th>
                <th>Qty</th>
                <th>Subtotal</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($items)): ?>
                <tr><td colspan="3" class="text-center">Keranjang kosong.</td></tr>
              <?php else: ?>
                <?php foreach ($items as $item): ?>
                  <tr>
                    <td><?= esc($item['product']['name']) ?></td>
                    <td><?= esc($item['quantity']) ?></td>
                    <td>Rp<?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
            <tfoot>
              <?php if ($coupon): ?>
                <tr>
                  <td colspan="2"><strong>Kupon:</strong> <?= esc($coupon) ?></td>
                  <td>-Rp<?= number_format($discount, 0, ',', '.') ?></td>
                </tr>
              <?php endif; ?>
              <tr>
                <td colspan="2"><strong>Total</strong></td>
                <td><strong>Rp<?= number_format($total, 0, ',', '.') ?></strong></td>
              </tr>
            </tfoot>
          </table>
        </div>
        <div class="text-end mt-3">
          <button class="btn btn-success">Proses Pesanan</button>
        </div>
      </div>
    </div>
  </form>
</div>

<?= $this->endSection() ?>
