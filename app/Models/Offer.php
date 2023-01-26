<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
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
    public function offer_type()
    {
        return $this->belongsTo(OfferType::class)->select('id', 'name', 'en_name');
    }
    public function offer_details()
    {
        return $this->hasMany(OfferDetail::class);
    }
    public function offer_specifications()
    {
        return $this->hasMany(OfferSpecification::class);
    }
}
