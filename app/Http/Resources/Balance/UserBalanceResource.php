<?php

namespace App\Http\Resources\Balance;

use Illuminate\Http\Resources\Json\JsonResource;

class UserBalanceResource extends JsonResource
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
            'balance' => $this->balance
        ];
    }
}
