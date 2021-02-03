<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id', 'sku', 'name', 'slug', 'description', 'quantity',
        'weight', 'price', 'sale_price', 'status', 'featured',
    ];


    public function setNameAttribute($name)
    {
        $this->attributes['name'] = $name;
        $this->attributes['slug'] = Str::slug($name);
    }

    public function Images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function Brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function Categories()
    {
        return $this->belongsToMany(Category::class,"product_categories","product_id","category_id");
    }

    public function ProductAttributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }
}
