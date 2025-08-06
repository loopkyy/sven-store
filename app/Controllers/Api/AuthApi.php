<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;

class AuthApi extends BaseController
{
    use ResponseTrait;

    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = session();
    }

public function register()
{
    $data = $this->request->getJSON(true);

    $rules = [
        'username' => 'required|min_length[3]',
        'email'    => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[6]',
    ];

    if (!$this->validateData($data, $rules)) {
        return $this->failValidationErrors($this->validator->getErrors());
    }

    $insertData = [
        'username'  => $data['username'],
        'email'     => $data['email'],
        'password'  => password_hash($data['password'], PASSWORD_DEFAULT),
        'phone'     => $data['phone'] ?? '',
        'address'   => $data['address'] ?? '',
        'role'      => 'customer',
        'is_active' => 1
    ];

    $this->userModel->insert($insertData);

    return $this->respondCreated([
        'status' => true,
        'message' => 'Registrasi berhasil.'
    ]);
}

    public function login()
{
    $data = $this->request->getJSON(true);
    $email = $data['email'] ?? null;
    $password = $data['password'] ?? null;

    $user = $this->userModel->where('email', $email)->first();

    if (!$user || !password_verify($password, $user['password'])) {
        return $this->failUnauthorized('Email atau password salah.');
    }

    if (!$user['is_active']) {
        return $this->fail('Akun Anda belum aktif.', 403);
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

    return $this->respond([
        'status' => true,
        'message' => 'Login berhasil',
        'user' => [
            'id'       => $user['id'],
            'username' => $user['username'],
            'email'    => $user['email'],
            'phone'    => $user['phone'],
            'address'  => $user['address'],
            'role'     => $user['role'],
        ]
    ]);
}

    public function logout()
    {
        $this->session->destroy();

        return $this->respond([
            'status' => true,
            'message' => 'Logout berhasil.'
        ]);
    }
}
