<?php
namespace App\Http\Controllers\Qvm;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiTrait;
use App\Http\Traits\QVMTrait;

class OrderController extends Controller
{

    use ApiTrait;
    use QVMTrait;
    public function offer_to_order($offer_id , $selected_items = [])
    {
        // $endpoint = config('app.qvm_new_url') . '/product/v1/qvm/in/products';
        // $products = $this->postData($endpoint, ['ids' => $product_ids]);
        // $products_array = [];
        // if (isset($products) && is_array($products)) {
        //     foreach ($products as $product) {
        //         $products_array[$product['productId']] = $product;
        //     }
        // }
        // return $products_array;
    }
}
