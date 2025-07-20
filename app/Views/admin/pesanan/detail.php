<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('title') ?>Detail Pesanan<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="fw-bold py-3 mb-4">Detail Pesanan #<?= $order['id'] ?></h4>

<div class="card mb-4">
  <div class="card-body">
    <p><strong>Nama Pembeli:</strong> <?= esc($order['user_name']) ?></p>
    <p><strong>Metode Pembayaran:</strong> <?= esc($order['payment_method_name'] ?? '–') ?></p>

    <p><strong>Status:</strong>
      <span class="badge <?= match ($order['status']) {
        'paid' => 'bg-success',
        'cancelled' => 'bg-danger',
        default => 'bg-warning text-dark'
      } ?>">
        <?= ucfirst($order['status']) ?>
      </span>
    </p>
    <p><strong>Total:</strong> <span class="text-primary fw-bold">Rp<?= number_format($order['total'], 0, ',', '.') ?></span></p>
    <p><strong>Tanggal:</strong> <?= date('d M Y H:i', strtotime($order['created_at'])) ?></p>

    <?php if ($order['status'] === 'pending'): ?>
      <form action="<?= base_url('admin/pesanan/update-status/' . $order['id']) ?>" method="post" class="d-flex gap-2 mt-3">

        <?= csrf_field() ?>
        <button type="submit" name="status" value="paid" class="btn btn-success" onclick="return confirm('Tandai sebagai Lunas?')">✔ Tandai Lunas</button>
        <button type="submit" name="status" value="cancelled" class="btn btn-danger" onclick="return confirm('Batalkan pesanan ini?')">✖ Batalkan</button>
      </form>
    <?php endif ?>
  </div>
</div>

<a href="<?= base_url('admin/pesanan/invoice/' . $order['id']) ?>" target="_blank" class="btn btn-outline-primary mb-3">

  <i class="bx bx-file"></i> Unduh Invoice
</a>

<form action="<?= base_url('admin/pesanan/update-shipping/' . $order['id']) ?>" method="post" class="mb-3">

  <label class="form-label fw-bold">Status Pengiriman:</label>
  <select name="shipping_status" class="form-control mb-2">
    <option value="belum dikirim" <?= $order['shipping_status'] == 'belum dikirim' ? 'selected' : '' ?>>Belum Dikirim</option>
    <option value="dikirim" <?= $order['shipping_status'] == 'dikirim' ? 'selected' : '' ?>>Dikirim</option>
    <option value="diterima" <?= $order['shipping_status'] == 'diterima' ? 'selected' : '' ?>>Diterima</option>
  </select>
  <button class="btn btn-primary btn-sm">Update Status Pengiriman</button>
</form>

<div class="card">
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>Produk</th>
          <th>Harga</th>
          <th>Qty</th>
          <th>Subtotal</th>
        </tr>
      </thead>
      <tbody>
        <?php 
          $totalSemua = 0;
          foreach ($items as $item): 
            $totalSemua += $item['subtotal'];
        ?>
        <tr>
          <td><?= esc($item['product_name']) ?></td>
          <td>Rp<?= number_format($item['price'], 0, ',', '.') ?></td>
          <td><?= $item['quantity'] ?></td>
          <td>Rp<?= number_format($item['subtotal'], 0, ',', '.') ?></td>
        </tr>
        <?php endforeach ?>
        <tr class="fw-bold bg-light">
          <td colspan="3" class="text-end">Total</td>
          <td>Rp<?= number_format($totalSemua, 0, ',', '.') ?></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<a href="<?= base_url('admin/pesanan') ?>" class="btn btn-secondary mt-3">← Kembali</a>
<?= $this->endSection() ?>
