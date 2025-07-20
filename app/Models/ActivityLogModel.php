<?php  

namespace App\Models;

use CodeIgniter\Model;

class ActivityLogModel extends Model
{
    protected $table = 'activity_logs';
    protected $allowedFields = ['user_id', 'activity'];
    public $timestamps = false;
}

