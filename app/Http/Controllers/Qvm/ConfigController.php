<?php
namespace App\Http\Controllers\Qvm;

use App\Http\Traits\ApiTrait;
use App\Models\OfferType;
use App\Http\Controllers\Controller;


class ConfigController extends Controller
{
    use ApiTrait;
    public function offer_types()
    {
        $offer_types = OfferType::select('id', 'name', 'en_name')->get();
        $ResponseMessage = __("data retrieved successfully");
        $check_success = $this->check_success($ResponseMessage, $offer_types);
        return $check_success;
    }



    
}
