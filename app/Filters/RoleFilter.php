<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Pastikan user sudah login
        if (!$session->get('user')['logged_in'] ?? false) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil daftar role yang diizinkan dari argument filter
        $allowedRoles = $arguments ?? [];

        // Jika tidak ada role yang diberikan di filter, berarti tidak batasi role (boleh akses)
        if (empty($allowedRoles)) {
            return; // Lanjutkan akses
        }

        // Ambil role dari session user
        $userRole = $session->get('user')['role'] ?? 'guest';

        // Cek apakah role user ada di dalam daftar yang diperbolehkan
        if (!in_array($userRole, $allowedRoles)) {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu aksi khusus setelah request
    }
}
