<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class LoginController extends BaseController
{
    public function index()
    {
        // Jika sudah login, langsung ke dashboard
        if (session()->has('user')) {
            return redirect()->to('/admin/dashboard');
        }

        return view('admin/login');
    }

    public function authenticate()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        if (empty($username) || empty($password)) {
            return redirect()->back()->with('error', 'Username dan password harus diisi.');
        }

        $userModel = new UserModel();
        $user = $userModel->where('username', $username)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Username atau password salah.');
        }

        if (!$user['is_active']) {
            return redirect()->back()->with('error', 'Akun Anda tidak aktif.');
        }

        // Simpan ke session
        session()->set('user', [
            'id'        => $user['id'],
            'username'  => $user['username'],
            'role'      => $user['role'],
            'logged_in' => true,
        ]);

        // Catat log aktivitas login
        log_activity("Login sebagai {$user['username']}");

        return redirect()->to('/admin/dashboard');
    }

    public function logout()
    {
        log_activity("Logout oleh " . (session()->get('user')['username'] ?? 'Unknown'));

        session()->destroy();
        return redirect()->to('/admin/login')->with('success', 'Anda telah logout.');
    }
}
