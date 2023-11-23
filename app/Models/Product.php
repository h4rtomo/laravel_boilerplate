<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
    ];

    const CREATE_RULE = [
        'name' => 'required',
        'description' => 'required',
        'price' => 'required|gte:0',
        'stock' => 'required|gte:0',
    ];

    const CREATE_RULE_MESSAGE = [
        'name.required' => 'Name is required',
    ];
}
