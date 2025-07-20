<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ContactModel;

class ContactController extends BaseController
{
    protected $contactModel;

    public function __construct()
    {
        $this->contactModel = new ContactModel();
    }

    // Menampilkan semua pesan kontak
    public function index()
    {
        $contacts = $this->contactModel
            ->orderBy('status', 'ASC') // Tampilkan pesan baru terlebih dahulu
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('admin/kontak/index', ['contacts' => $contacts]);
    }

    // Menghapus pesan kontak
    public function delete($id)
    {
        $contact = $this->contactModel->find($id);

        if (!$contact) {
            return redirect()->to('admin/kontak')->with('error', 'Pesan tidak ditemukan.');
        }

        $this->contactModel->delete($id);

        if (method_exists($this, 'logActivity')) {
            $this->logActivity("Menghapus pesan kontak ID $id");
        }

        return redirect()->to('admin/kontak')->with('success', 'Pesan berhasil dihapus.');
    }

    // Menandai pesan sebagai telah dibaca
    public function markRead($id)
    {
        $contact = $this->contactModel->find($id);

        if (!$contact) {
            return redirect()->to('admin/kontak')->with('error', 'Pesan tidak ditemukan.');
        }

        if ($contact['status'] === 'read') {
            return redirect()->to('admin/kontak')->with('success', 'Pesan sudah ditandai sebelumnya.');
        }

        $this->contactModel->update($id, ['status' => 'read']);
        return redirect()->to('admin/kontak')->with('success', 'Pesan ditandai sebagai telah dibaca.');
    }
}
