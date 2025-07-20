<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PaymentMethodModel;

class PaymentController extends BaseController
{
    protected $paymentModel;

    public function __construct()
    {
        $this->paymentModel = new PaymentMethodModel();
    }

    public function index()
    {
        $data['methods'] = $this->paymentModel->findAll();
        return view('admin/pembayaran/index', $data);
    }

    public function create()
    {
        return view('admin/pembayaran/create');
    }

    public function store()
    {
        $rules = [
            'name' => 'required',
            'type' => 'required|in_list[cod,bank_transfer,qris]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->paymentModel->save([
            'name'      => $this->request->getPost('name'),
            'type'      => $this->request->getPost('type'),
            'details'   => $this->request->getPost('details'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return redirect()->to('/admin/pembayaran')->with('success', 'Metode pembayaran berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $method = $this->paymentModel->find($id);
        if (!$method) {
            return redirect()->to('/admin/pembayaran')->with('error', 'Metode pembayaran tidak ditemukan.');
        }

        return view('admin/pembayaran/edit', ['method' => $method]);
    }

    public function update($id)
    {
        $rules = [
            'name' => 'required',
            'type' => 'required|in_list[cod,bank_transfer,qris]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->paymentModel->update($id, [
            'name'      => $this->request->getPost('name'),
            'type'      => $this->request->getPost('type'),
            'details'   => $this->request->getPost('details'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return redirect()->to('/admin/pembayaran')->with('success', 'Metode pembayaran diperbarui.');
    }

    public function delete($id)
    {
        $method = $this->paymentModel->find($id);
        if (!$method) {
            return redirect()->to('/admin/pembayaran')->with('error', 'Metode pembayaran tidak ditemukan.');
        }

        $this->paymentModel->delete($id);

        if (function_exists('log_activity')) {
            log_activity("Menghapus metode pembayaran: " . $method['name']);
        }

        return redirect()->to('/admin/pembayaran')->with('success', 'Metode pembayaran dihapus.');
    }
}
