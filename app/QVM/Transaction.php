<?php

namespace App\Models\QVM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'wallet_id',
        'user_id',
        'order_id',
        'description_id',
        'type',
        'amount',
        'balance',
        'status',
    ];

    protected $appends = [
        'status_key',
        'status_name',
        'type_key',
        'type_name',
    ];

    const TYPES_TRANSACTION = [
        1 => 'deposit',
        2 => 'withdraw'
    ];

    const STATUS_TRANSACTION = [
        0 => 'failure',
        1 => 'success'
    ];

    // Accessors & Mutators
    public function getStatusKeyAttribute()
    {
        return Self::STATUS_TRANSACTION[$this->status];
    }

    public function getStatusNameAttribute()
    {
        return __('status.' . $this->getStatusKeyAttribute());
    }

    public function getTypeKeyAttribute()
    {
        return Self::TYPES_TRANSACTION[$this->type];
    }

    public function getTypeNameAttribute()
    {
        return __('status.' . $this->getTypeKeyAttribute());
    }

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'wallet_id');
    }

}
