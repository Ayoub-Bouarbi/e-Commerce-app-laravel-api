<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name','last_name','zip_code','country','state','city','address','phone_number','order_number','user_id'
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function OrderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
