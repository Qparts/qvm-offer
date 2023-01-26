<?php
namespace App\Models\QVM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public function payment_type()
    {
        return $this->belongsTo(PaymentType::class)->select('id' , 'name' , 'en_name');
    }



    public function shipping_type()
    {
        return $this->belongsTo(ShippingType::class)->select('id' , 'name' , 'en_name');
    }

    public function shipping_method()
    {
        return $this->belongsTo(ShippingMethod::class)->select('id' , 'name' , 'en_name');
    }





    public function order_status()
    {
        return $this->belongsTo(OrderStatus::class)->select('id' , 'name' , 'en_name');
    }


    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class)->select('id' , 'name' , 'en_name');
    }
    public function order_items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function distance_unit()
    {
        return $this->belongsTo(DistanceUnit::class)->select('id' , 'name' , 'en_name');
    }

    public function order_items_availability()
    {
        return $this->belongsTo(OrderItemsAvailability::class)->select('id' , 'name' , 'en_name');
    }



    public function getOrderItemsAvailabilityIdAttribute($value) {

        // $order_items = OrderItem::whereOrderId($this->id)->select(DB::raw('count(*) as count_availability')->groupby();
        return $value;
    }

}
