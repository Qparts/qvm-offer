<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;

 
    protected $casts = [
        'is_active' => 'boolean',
       // 'created_at' => 'datetime:Y-m-d',
    ];

    protected function Image(): Attribute
    {
        return Attribute::make(
            get:fn($value) => asset($value),
        );
    }
}
