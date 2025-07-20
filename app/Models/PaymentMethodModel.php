<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentMethodModel extends Model
{
    protected $table      = 'payment_methods';
    protected $primaryKey = 'id';

    protected $allowedFields = ['name', 'type', 'details', 'is_active'];

    protected $useTimestamps = true;
}
