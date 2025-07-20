<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class MaintenanceFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Kecualikan admin, login, CLI, dan API (opsional)
        if (is_cli() || str_starts_with($request->getPath(), 'admin') || str_starts_with($request->getPath(), 'login') || str_starts_with($request->getPath(), 'api')) {
            return;
        }

        // Ambil nilai maintenance mode
        $settingModel = new \App\Models\SettingModel();
        $mode = $settingModel->where('key_name', 'maintenance_mode')->first();

        if ($mode && $mode['value'] === 'on') {
            return \Config\Services::response()
                ->setStatusCode(503)
                ->setBody(view('errors/maintenance'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
