<?php

namespace App\Models\QVM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;



    

    public function purchase_order_status()
    {
        return $this->belongsTo(PurchaseOrderStatus::class)->select('id' , 'name' , 'en_name');;
    }

    public function payment_status()
    {
        return $this->belongsTo(PaymentStatus::class)->select('id' , 'name' , 'en_name');;
    }


    public function shipping_type()
    {
        return $this->belongsTo(ShippingType::class)->select('id' , 'name' , 'en_name');;
    }


    
    public function shipping_method()
    {
        return $this->belongsTo(ShippingMethod::class)->select('id' , 'name' , 'en_name');;
    }


    public function order_items_availability()
    {
        return $this->belongsTo(OrderItemsAvailability::class)->select('id' , 'name' , 'en_name');;
    }

    
    public function payment_type()
    {
        return $this->belongsTo(PaymentType::class)->select('id' , 'name' , 'en_name');;
    }
    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class)->select('id' , 'name' , 'en_name');;
    }
    public function purchase_order_items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }


 


}
