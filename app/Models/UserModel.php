<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'username', 'email', 'phone', 'address', 'password',
        'role', 'is_active', 'avatar', // ✅ Tambahkan 'avatar' di sini
        'created_at', 'updated_at'
    ];

    protected $useTimestamps = true;
}
