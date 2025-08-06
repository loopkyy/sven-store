<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;

class AccountApi extends ResourceController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // 📄 Lihat profil
    public function profile()
{
    $session = session()->get();

    if (!$session || empty($session['isLoggedIn'])) {
        return $this->failUnauthorized('Belum login.');
    }

    // ✅ Ambil ulang user dari database, bukan dari session
    $user = $this->userModel->find($session['user_id']);

    if (!$user) {
        return $this->failNotFound('User tidak ditemukan.');
    }

    return $this->respond([
        'status' => true,
        'user' => [
            'id'         => $user['id'],
            'username'   => $user['username'],
            'email'      => $user['email'],
            'phone'      => $user['phone'],
            'address'    => $user['address'],
            'role'       => $user['role'],
            'avatar'     => $user['avatar'], // (optional) simpan nama file
            'avatar_url' => $user['avatar'] 
                ? base_url('uploads/avatars/' . $user['avatar']) 
                : null, // ✅ inilah yang dibutuhkan frontend
        ]
    ]);
}


    // 🔁 Update profil
    public function updateProfile()
    {
        $user = session()->get();

        if (!$user || empty($user['isLoggedIn'])) {
            return $this->failUnauthorized('Belum login.');
        }

        $data = $this->request->getJSON(true);

        $rules = [
            'username' => 'required',
            'email'    => 'required|valid_email',
            'phone'    => 'required',
            'address'  => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        // ✅ Update ke database
        $this->userModel->update($user['user_id'], [
            'username' => $data['username'],
            'email'    => $data['email'],
            'phone'    => $data['phone'],
            'address'  => $data['address'],
        ]);

        // ✅ Update juga data di session (jika dibutuhkan oleh navbar atau auth info)
        session()->set([
            'user_name'  => $data['username'],
            'user_email' => $data['email'],
            'phone'      => $data['phone'],
            'address'    => $data['address'],
        ]);

        return $this->respond([
            'status' => true,
            'message' => 'Profil berhasil diperbarui',
            'data' => $data
        ]);
    }

    // 🔑 Ganti password
    public function changePassword()
    {
        $user = session()->get();

        if (!$user || empty($user['isLoggedIn'])) {
            return $this->failUnauthorized('Belum login.');
        }

        $data = $this->request->getJSON(true);

        if (!isset($data['old_password'], $data['new_password'], $data['confirm_password'])) {
            return $this->fail('Semua field password harus diisi.');
        }

        $rules = [
            'old_password'     => 'required',
            'new_password'     => 'required|min_length[6]',
            'confirm_password' => 'required|matches[new_password]',
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $userData = $this->userModel->find($user['user_id']);

        if (!password_verify($data['old_password'], $userData['password'])) {
            return $this->fail('Password lama salah.');
        }

        $this->userModel->update($user['user_id'], [
            'password' => password_hash($data['new_password'], PASSWORD_DEFAULT)
        ]);

        return $this->respond([
            'status' => true,
            'message' => 'Password berhasil diubah'
        ]);
    }
public function uploadAvatar()
{
    $user = session()->get();
    if (!$user || empty($user['isLoggedIn'])) {
        return $this->failUnauthorized('Belum login.');
    }

    $file = $this->request->getFile('avatar');
    if (!$file || !$file->isValid()) {
        return $this->fail('File avatar tidak valid.');
    }

    $ext = $file->getClientExtension();
    $newName = 'avatar_' . $user['user_id'] . '.' . $ext;
    $path = FCPATH . 'uploads/avatars/';

    if (!is_dir($path)) {
        mkdir($path, 0755, true);
    }

    $file->move($path, $newName);

    // ✅ Tambahkan ini untuk menyimpan ke database
    $this->userModel->update($user['user_id'], [
        'avatar' => $newName
    ]);

    $avatarUrl = base_url('uploads/avatars/' . $newName);

    return $this->respond([
        'status' => true,
        'message' => 'Avatar berhasil diupload.',
        'avatar_url' => $avatarUrl,
    ]);
}

}
