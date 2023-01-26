<?php

namespace App\Http\Resources\Transaction;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'order_id' => $this->order_id,
            'amount' => $this->amount,
            'balance' => $this->balance,
            'description' => $this->description,
            'type_name' => $this->type_name,
            'status_name' => $this->status_name,
            'created_at' => $this->created_at->format('Y-m-d h:ia'),
        ];
    }
}
