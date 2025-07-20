<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table = 'settings';
    protected $allowedFields = ['key_name', 'value', 'created_at', 'updated_at'];
    public $timestamps = true;
}
