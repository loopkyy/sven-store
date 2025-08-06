<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductReviewModel extends Model
{
    protected $table      = 'product_reviews';
    protected $primaryKey = 'id';

    protected $useTimestamps = true; // Aktifkan created_at dan updated_at
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; // Kosongkan karena kamu hanya pakai created_at

    protected $allowedFields = ['product_id', 'user_id', 'rating', 'comment', 'created_at'];

    protected $validationRules = [
        'product_id' => 'required|integer',
        'user_id'    => 'required|integer',
        'rating'     => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[5]',
        'comment'    => 'permit_empty|string'
    ];
}
