<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOfferAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
 
        
        
        return [
            'image' => 'required|image',
            'offer_title' => 'required',
            'offer_expiry_date' => 'required',
            'offer_type_id' => 'required',
            'seller_id' => 'required',
            'minimum_order_quantity' => 'required',
            'minimum_order_amount' => 'required',
           'offer_details' => 'required|array',
           'offer_details.*.product_id' => 'required',
           'offer_details.*.offer_price' => 'required|numeric',
           'offer_details.*.offer_quantity' => 'required|numeric',
           'offer_details.*.minimum_order_quantity' => 'required|numeric',
           'offer_details.*.maximum_order_quantity' => 'required|numeric',
           
           'offer_specifications' => 'required|array',
           'offer_specifications.*.offer_specification' => 'required|string',

           
           
        ];
    }
}
