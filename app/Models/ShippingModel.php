<?php

namespace App\Models;

use CodeIgniter\Model;

class ShippingModel extends Model
{
    protected $table      = 'shippings';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'price'];
}
