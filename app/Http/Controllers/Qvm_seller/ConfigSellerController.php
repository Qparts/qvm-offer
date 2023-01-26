<?php
namespace App\Http\Controllers\Qvm_seller;

use App\Http\Traits\ApiTrait;
use App\Models\OfferType;
use App\Http\Controllers\Controller;
use App\Http\Traits\QVMTrait;

class ConfigSellerController extends Controller
{
    use ApiTrait;
    use QVMTrait;

    public function company_labels()
    {
        $url = 'http://dev.fareed9.com:3000/subscriber/company-labels';
        $labels = $this->getData($url , []);
        $ResponseMessage = __("data retrieved successfully");
        $check_success = $this->check_success($ResponseMessage, $labels);
        return $check_success;
    }



    
}
