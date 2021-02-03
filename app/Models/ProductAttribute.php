<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        "quantity","price","value","product_id",'attribute_id'
    ];

    public function Product()
    {
        return $this->belongsTo(Product::class);
    }

    public function Attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
