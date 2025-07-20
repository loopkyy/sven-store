<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useTimestamps    = true;

    protected $allowedFields    = [
        'name',
        'description',
        'price',
        'stock',
        'category_id',
        'image',
        'is_active',
        'slug',
        'is_best_seller', 
        'rating'           
    ];

    // Optional: relasi ke kategori
    public function withCategory()
    {
        return $this->select('products.*, categories.name as category_name')
                    ->join('categories', 'categories.id = products.category_id', 'left');
    }
}
