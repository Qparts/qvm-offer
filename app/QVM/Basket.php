<?php

namespace App\Models\QVM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    use HasFactory;


    public function basket_items()
    {
        return $this->hasMany(BasketItem::class);
    }
}
