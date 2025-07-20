<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\NewsletterModel;

class NewsletterController extends BaseController
{
    protected $newsletterModel;

    public function __construct()
    {
        $this->newsletterModel = new NewsletterModel();
    }

    public function subscribe()
    {
        $email = $this->request->getPost('email');

        // Validasi email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->with('error', 'Email tidak valid.');
        }

        // Cek jika email sudah terdaftar dan aktif
        $existing = $this->newsletterModel->where('email', $email)->first();
        if ($existing) {
            if ($existing['subscribed']) {
                return redirect()->back()->with('error', 'Email sudah terdaftar.');
            } else {
                // Kalau sebelumnya unsubscribed, aktifkan lagi
                $this->newsletterModel->update($existing['id'], ['subscribed' => 1]);
                return redirect()->back()->with('success', 'Berhasil langganan kembali!');
            }
        }

        // Simpan baru
        $this->newsletterModel->insert([
            'email'      => $email,
            'subscribed' => 1
        ]);

        return redirect()->back()->with('success', 'Berhasil langganan newsletter!');
    }
}
