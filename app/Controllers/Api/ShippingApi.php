<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ShippingModel;

class ShippingApi extends ResourceController
{
    protected $modelName = 'App\Models\ShippingModel';
    protected $format    = 'json';

    public function index()
    {
        $data = $this->model->findAll();

        return $this->respond([
            'status' => true,
            'message' => 'Daftar kurir tersedia.',
            'data' => $data
        ]);
    }
}
