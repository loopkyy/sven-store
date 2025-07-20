<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsletterModel extends Model
{
    protected $table = 'newsletters';
    protected $primaryKey = 'id';
    protected $allowedFields = ['email', 'subscribed', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
