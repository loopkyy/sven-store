<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = session();
    }

    public function showLogin()
    {
        return view('frontend/auth/login');
    }

    public function showRegister()
    {
        return view('frontend/auth/register');
    }

    public function register()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => 'required|min_length[3]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
    'username'  => $this->request->getPost('username'),
    'email'     => $this->request->getPost('email'),
    'password'  => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
    'phone'     => $this->request->getPost('phone'),
    'address'   => $this->request->getPost('address'),
    'role'      => 'customer',
    'is_active' => 1
];

        $this->userModel->insert($data);

        return redirect()->to('/login')->with('success', 'Akun berhasil dibuat, silakan login.');
    }

    public function login()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->userModel->where('email', $email)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Email atau password salah.');
        }

        if (!$user['is_active']) {
            return redirect()->back()->with('error', 'Akun Anda belum aktif.');
        }

        $this->session->set([
    'user_id'    => $user['id'],
    'user_name'  => $user['username'],
    'user_email' => $user['email'],
    'phone'      => $user['phone'],    
    'address'    => $user['address'],   
    'role'       => $user['role'],
    'isLoggedIn' => true,
]);


        return redirect()->to('/');
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/');
    }
}
