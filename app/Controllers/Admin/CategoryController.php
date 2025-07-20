<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;

class CategoryController extends BaseController
{
    public function index()
    {
        $model = new CategoryModel();
        $data['categories'] = $model->findAll();
        return view('admin/kategori/index', $data);
    }

    public function create()
    {
        return view('admin/kategori/create');
    }

    public function store()
    {
        $model = new CategoryModel();
        $model->save([
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ]);
        // Redirect ke /admin/kategori karena route-nya ada di group 'admin'
        return redirect()->to('/admin/kategori')->with('success', 'Kategori ditambahkan');
    }

    public function edit($id)
    {
        $model = new CategoryModel();
        $data['kategori'] = $model->find($id);
        return view('admin/kategori/edit', $data);
    }

    public function update($id)
    {
        $model = new CategoryModel();
        $model->update($id, [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ]);
        return redirect()->to('/admin/kategori')->with('success', 'Kategori diperbarui');
    }

    public function delete($id)
    {
        $model = new CategoryModel();
        $model->delete($id);
        return redirect()->to('/admin/kategori')->with('success', 'Kategori dihapus');
    }
}
