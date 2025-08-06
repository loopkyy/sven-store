<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ProductController extends BaseController
{
    public function index()
{
    $productModel = new ProductModel();
    $products = $productModel
        ->select('products.*, categories.name as category_name')
        ->join('categories', 'categories.id = products.category_id', 'left')
        ->paginate(10);

    $pager = $productModel->pager;

    return view('admin/produk/index', [
        'products' => $products,
        'pager' => $pager
    ]);
}


    public function create()
    {
        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->findAll();
        return view('admin/produk/create', $data);
    }

  public function store()
{
    $productModel = new ProductModel();
    $file = $this->request->getFile('image');

    $imageName = null;
    if ($file && $file->isValid()) {
        $imageName = $file->getRandomName();
        $file->move('uploads/', $imageName);
    }

    $price = str_replace(['Rp', '.', ' '], '', $this->request->getPost('price'));
    $slug  = url_title($this->request->getPost('name'), '-', true); // ✅ Tambahkan ini

    $productModel->save([
        'name'        => $this->request->getPost('name'),
        'slug'        => $slug, // ✅ gunakan di sini
        'description' => $this->request->getPost('description'),
        'price'       => $price,
        'stock'       => (int) $this->request->getPost('stock'),
        'category_id' => $this->request->getPost('category_id'),

        'image'       => $imageName
    ]);

    $this->logActivity("Menambahkan produk baru: " . $this->request->getPost('name'));

    return redirect()->to('/admin/produk')->with('success', 'Produk berhasil ditambahkan');
}

    public function edit($id)
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        return view('admin/produk/edit', [
            'product' => $productModel->find($id),
            'categories' => $categoryModel->findAll()
        ]);
    }

    public function update($id)
    {
        $productModel = new ProductModel();
        $file = $this->request->getFile('image');

        $data = [
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price'       => str_replace(['Rp', '.', ' '], '', $this->request->getPost('price')),
            'stock'       => (int) $this->request->getPost('stock'),
            'category_id' => $this->request->getPost('category_id'),
        ];

        if ($file && $file->isValid()) {
            $imageName = $file->getRandomName();
            $file->move('uploads/', $imageName);
            $data['image'] = $imageName;
        }

        $productModel->update($id, $data);

        $this->logActivity("Mengupdate produk: " . $this->request->getPost('name'));

        return redirect()->to('/admin/produk')->with('success', 'Produk berhasil diperbarui');
    }

    public function delete($id)
    {
        $productModel = new ProductModel();
        $product = $productModel->find($id);

        if ($product && $product['image']) {
            $imagePath = FCPATH . 'uploads/' . $product['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $productModel->delete($id);
        if ($product) {
            $this->logActivity("Menghapus produk: " . $product['name']);
        }

        return redirect()->to('/admin/produk')->with('success', 'Produk berhasil dihapus');
    }


public function importForm()
{
    return view('admin/produk/import');
}

public function importExcel()
{
    $file = $this->request->getFile('file_excel');
    if (!$file->isValid()) {
        return redirect()->back()->with('error', 'File tidak valid.');
    }

    $spreadsheet = IOFactory::load($file->getTempName());
    $sheet = $spreadsheet->getActiveSheet()->toArray();

    $productModel  = new ProductModel();
    $categoryModel = new CategoryModel();
    $errors        = [];
    $successCount  = 0;

    foreach ($sheet as $i => $row) {
        if ($i === 0) continue; // skip header

        // Pastikan array selalu memiliki panjang minimal 9 kolom
        $row = array_pad($row, 9, null);
        [$name, $desc, $price, $stock, $categoryName, $image, $rating, $is_best_seller, $slug] = $row;

        // Lewati baris kosong
        if (empty($name) && empty($desc) && empty($price) && empty($stock) && empty($categoryName)) {
            continue;
        }

        // Validasi kategori
        $category = $categoryModel->where('name', $categoryName)->first();
        if (!$category) {
            $errors[] = "Baris " . ($i + 1) . ": Kategori '$categoryName' tidak ditemukan.";
            continue;
        }

        // Generate slug jika belum ada
        $slug = $slug ?: url_title($name, '-', true);

        // Simpan produk
        $productModel->insert([
            'name'           => $name,
            'slug'           => $slug,
            'description'    => $desc,
            'price'          => $price,
            'stock'          => $stock,
            'category_id'    => $category['id'],
            'image'          => $image ?: null,
            'rating'         => $rating ?: 5,
            'is_best_seller' => $is_best_seller ?: 0,
            'is_active'      => 1,
        ]);

        $successCount++;
    }

    if ($successCount > 0) {
        $this->logActivity("Import $successCount produk dari file Excel.");
    }

    if (!empty($errors)) {
        return redirect()->back()->with('error', implode('<br>', $errors));
    }

    return redirect()->to('/admin/produk')->with('success', "Import produk berhasil. Total: $successCount produk.");
}


    public function uploadImage($id)
    {
        $productModel = new ProductModel();
        $product = $productModel->find($id);

        if (!$product) {
            return $this->response->setJSON(['success' => false, 'message' => 'Produk tidak ditemukan.']);
        }

        $file = $this->request->getFile('image');
        if (!$file->isValid()) {
            return $this->response->setJSON(['success' => false, 'message' => 'File tidak valid.']);
        }

        // Hapus gambar lama
        if ($product['image']) {
            $oldImagePath = FCPATH . 'uploads/' . $product['image'];
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        $imageName = $file->getRandomName();
        $file->move('uploads/', $imageName);

        $productModel->update($id, ['image' => $imageName]);
        $this->logActivity("Mengunggah ulang gambar produk: " . $product['name']);

        return $this->response->setJSON([
            'success' => true,
            'image_url' => base_url('uploads/' . $imageName)
        ]);
    }
public function deleteAll()
{
    $productModel = new \App\Models\ProductModel();
    $productModel->where('id !=', 0)->delete(); // hapus semua kecuali id=0 (kalau ada default)

    session()->setFlashdata('success', 'Semua produk berhasil dihapus.');
    return redirect()->to(base_url('admin/produk'));
}


}
