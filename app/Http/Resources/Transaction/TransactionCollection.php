<?php

namespace App\Http\Resources\Transaction;

use App\Http\Resources\CustomResourceCollection;

class TransactionCollection extends CustomResourceCollection
{

    public function collections()
    {
        return TransactionResource::collection($this->collection);
    }

}
