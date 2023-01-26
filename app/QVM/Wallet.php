<?php

namespace App\Models\QVM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $table = 'wallets';

    protected $fillable = ['user_id', 'balance'];

    protected $casts = [
        'balance' => 'decimal:2'
    ];

    public function wallet($user_id)
    {
        return $this->firstOrCreate(['user_id' => $user_id], ['balance' => 0]);
    }

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'wallet_id');
    }

}
