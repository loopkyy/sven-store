<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AdminController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $admins = $this->userModel->where('role', 'admin')->findAll();
        return view('superadmin/index', ['admins' => $admins]);
    }

    public function create()
    {
        return view('superadmin/create');
    }

    public function store()
    {
        $rules = [
            'username' => 'required|min_length[3]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[5]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username'  => $this->request->getPost('username'),
            'email'     => $this->request->getPost('email'),
            'password'  => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'      => 'admin',
            'is_active' => 1,
        ];

        $this->userModel->insert($data);
        log_activity("Menambahkan admin baru: {$data['username']}");
        return redirect()->to('/superadmin')->with('success', 'Admin berhasil ditambahkan.');

    }

    public function edit($id)
    {
        $admin = $this->userModel->find($id);
        if (!$admin || $admin['role'] !== 'admin') {
            return redirect()->to('/superadmin/admin')->with('error', 'Admin tidak ditemukan.');
        }

        return view('superadmin/edit', ['admin' => $admin]);
    }

    public function update($id)
    {
        $admin = $this->userModel->find($id);
        if (!$admin || $admin['role'] !== 'admin') {
            return redirect()->to('/superadmin')->with('error', 'Admin tidak valid.');
        }

        $rules = [
            'username' => "required|min_length[3]|is_unique[users.username,id,{$id}]",
            'email'    => "required|valid_email|is_unique[users.email,id,{$id}]",
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $rules['password'] = 'min_length[5]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
        ];

        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $data);
        log_activity("Mengedit data admin: {$admin['username']}");
        return redirect()->to('/superadmin')->with('success', 'Data admin berhasil diperbarui.');
    }

    public function delete($id)
    {
        $admin = $this->userModel->find($id);
        if ($admin && $admin['role'] === 'admin') {
            $this->userModel->delete($id);
            log_activity("Menghapus admin: {$admin['username']}");
        }

        return redirect()->to('/superadmin')->with('success', 'Admin berhasil dihapus.');
    }

    public function toggle($id)
    {
        $admin = $this->userModel->find($id);
        if (!$admin || $admin['role'] !== 'admin') {
            return redirect()->back()->with('error', 'Admin tidak ditemukan.');
        }

        $newStatus = $admin['is_active'] ? 0 : 1;
        $this->userModel->update($id, ['is_active' => $newStatus]);

        log_activity("Mengubah status admin: {$admin['username']} menjadi " . ($newStatus ? 'Aktif' : 'Nonaktif'));

        return redirect()->back()->with('success', 'Status admin diperbarui.');
    }
}
