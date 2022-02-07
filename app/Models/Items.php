<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'price',
        'old_price',
        'description',
        'image',
        'url',
        'store_name'
    ];
}