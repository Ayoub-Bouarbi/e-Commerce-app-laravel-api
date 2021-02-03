<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        "name","frontend_type"
    ];

    public function AttributeValues()
    {
        return $this->hasMany(AttributeValue::class);
    }

    public function ProductAttributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }
}


