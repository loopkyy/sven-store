<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;
use App\Models\SettingModel;
use Config\Services;

class SettingController extends BaseController
{
    protected $settingModel;

    public function __construct()
    {
        $this->settingModel = new SettingModel();
    }

    public function index()
    {
        $q = $this->request->getGet('q');
        $query = $this->settingModel;

        if ($q) {
            $query = $query->like('key_name', $q)->orLike('value', $q);
        }

        $settings = $query->paginate(10);
        $pager    = $this->settingModel->pager;

        return view('superadmin/pengaturan/index', [
            'settings' => $settings,
            'pager'    => $pager,
            'q'        => $q,
        ]);
    }

    public function save()
    {
        foreach ($this->request->getPost() as $key => $value) {
            $existing = $this->settingModel->where('key_name', $key)->first();

            if ($existing) {
                $this->settingModel->set('value', $value)->where('key_name', $key)->update();
            } else {
                $this->settingModel->insert([
                    'key_name'   => $key,
                    'value'      => $value,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }

        $this->logActivity('Menyimpan perubahan pengaturan');
        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui.');
    }

    public function maintenance()
    {
        $mode = $this->request->getPost('mode');

        $this->settingModel
            ->where('key_name', 'maintenance_mode')
            ->set(['value' => $mode])
            ->update();

        $this->logActivity("Mengubah Maintenance Mode menjadi: $mode");

        return redirect()->back()->with('success', 'Maintenance Mode diperbarui.');
    }

    public function uploadLogo()
    {
        $file = $this->request->getFile('logo');

        if (!$file->isValid()) {
            return redirect()->back()->with('error', 'File tidak valid.');
        }

        $name = $file->getRandomName();
        $file->move('uploads', $name);

        // Resize logo
        Services::image()
            ->withFile('uploads/' . $name)
            ->resize(100, 100, true, 'height')
            ->save('uploads/' . $name);

        // Simpan ke settings
        $this->settingModel
            ->where('key_name', 'site_logo')
            ->set(['value' => $name])
            ->update();

        $this->logActivity("Mengunggah logo baru: $name");

        return redirect()->back()->with('success', 'Logo berhasil diunggah & diperkecil.');
    }

    protected function logActivity(string $message): void
    {
        if (function_exists('log_activity')) {
            log_activity($message);
        } else {
            $logModel = new \App\Models\ActivityLogModel();
            $logModel->insert([
                'user_id'  => session('user_id') ?? 0,
                'activity' => $message,
            ]);
        }
    }
    public function uploadFavicon()
{
    $file = $this->request->getFile('favicon');

    if (!$file->isValid()) {
        return redirect()->back()->with('error', 'File favicon tidak valid.');
    }

    $name = 'favicon_' . time() . '.' . $file->getExtension();
    $file->move('uploads', $name);

    // Simpan ke settings
    $this->settingModel
        ->where('key_name', 'site_favicon')
        ->set(['value' => $name])
        ->update();

    $this->logActivity("Mengunggah favicon baru: $name");

    return redirect()->back()->with('success', 'Favicon berhasil diperbarui.');
}

}
