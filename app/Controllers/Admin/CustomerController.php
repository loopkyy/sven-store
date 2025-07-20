<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class CustomerController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $customers = $this->userModel
            ->where('role', 'customer')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('admin/pelanggan/index', ['customers' => $customers]);
    }

    public function edit($id)
    {
        $pelanggan = $this->userModel->find($id);

        if (!$pelanggan || $pelanggan['role'] !== 'customer') {
            return redirect()->to('/pelanggan')->with('error', 'Pelanggan tidak ditemukan.');
        }

        return view('admin/pelanggan/edit', ['pelanggan' => $pelanggan]);
    }

public function update($id)
{
    $user = $this->userModel->find($id);
    if (!$user || $user['role'] !== 'customer') {
        return redirect()->to('/admin/pelanggan')->with('error', 'Pelanggan tidak ditemukan.');
    }

    $data = $this->request->getPost([
        'username', 'email', 'phone', 'address', 'is_active'
    ]);

    // Debug opsional
    // dd($data);

    $this->userModel->update($id, $data);
    return redirect()->to('/admin/pelanggan')->with('success', 'Data pelanggan berhasil diperbarui.');
}

    public function detail($id)
    {
        $user = $this->userModel->find($id);

        if (!$user || $user['role'] !== 'customer') {
            return redirect()->to('/pelanggan')->with('error', 'Pelanggan tidak ditemukan.');
        }

        return view('admin/pelanggan/detail', ['pelanggan' => $user]);
    }

    public function toggleStatus($id)
    {
        $user = $this->userModel->find($id);

        if (!$user || $user['role'] !== 'customer') {
            return redirect()->to('admin/pelanggan')->with('error', 'Pelanggan tidak ditemukan.');
        }

        $newStatus = $user['is_active'] ? 0 : 1;
        $this->userModel->update($id, ['is_active' => $newStatus]);

        return redirect()->to('admin/pelanggan')->with('success', 'Status pelanggan berhasil diperbarui.');
    }
    public function delete($id)
{
    $user = $this->userModel->find($id);

    if (!$user || $user['role'] !== 'customer') {
        return redirect()->to('/admin/pelanggan')->with('error', 'Pelanggan tidak ditemukan.');
    }

    $this->userModel->delete($id);
    return redirect()->to('/admin/pelanggan')->with('success', 'Pelanggan berhasil dihapus.');
}

}
