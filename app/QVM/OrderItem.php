<?php

namespace App\Models\QVM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;



    public function order_items_availability()
    {
        return $this->belongsTo(OrderItemsAvailability::class)->select('id' , 'name' , 'en_name');
    }

    
}
