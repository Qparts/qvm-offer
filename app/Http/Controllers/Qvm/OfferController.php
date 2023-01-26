<?php
namespace App\Http\Controllers\Qvm;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOfferOrderRequest;
use App\Http\Traits\ApiTrait;
use App\Http\Traits\QVMTrait;
use App\Models\Offer;
use App\Models\OfferOrder;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    use ApiTrait;
    use QVMTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $Offers = Offer::with(['offer_type', 'offer_details', 'offer_specifications'])->whereHas('offer_details', function ($q) use ($data) {
            if (isset($data['product_id'])) {
                return $q->where('product_id', $data['product_id']);
            }
        })->orderby('id', 'DESC')->paginate(10);
// $custom = collect(['data' => 'My custom data here']);
// $data = $custom->merge($Offers);
// return response()->json($data);
        $ResponseMessage = __("data retrieved successfully");
        $check_success = $this->check_success($ResponseMessage, $Offers);
        return $check_success;
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function show(Offer $offer, $id)
    {
        $Offers = Offer::with(['offer_type', 'offer_details', 'offer_specifications'])->find($id);
        $ResponseMessage = __("data retrieved successfully");
        $check_success = $this->check_success($ResponseMessage, $Offers);
        return $check_success;
    }
    public function add_order(StoreOfferOrderRequest $request ,  $offer_id)
    {
        // $data = ["order_items" => [
        //     [
        //         "product_id" => 2015,
        //         "quantity" => 10,
        //     ],
        //     [
        //         "product_id" => 2016,
        //         "quantity" => 20,
        //     ],
        // ]];

        $data = $request->all();
        $endpoint = config('app.qvm_order_url') . '/orders/add_direct_order';
        $data = $this->postData($endpoint, $data);
        if (isset($data['status']) && $data['status'] == true) {
            $orders = $data['data'];
            foreach ($orders as $order) {
                $exist_order = OfferOrder::whereOfferId($offer_id)->whereOrderId($order['id'])->first();
                if (!$exist_order) {
                    $OfferOrder = new OfferOrder();
                    $OfferOrder->order_id = $order['id'];
                    $OfferOrder->offer_id = $offer_id;
                    $OfferOrder->save();
                }

            }
            $orders = OfferOrder::whereOfferId($offer_id)->get();
            $ResponseMessage = __("data stored successfully");
            $check_success = $this->check_success($ResponseMessage, $orders);
            return $check_success;
        } else {
            $ResponseMessage = __("oops");
            $check_success = $this->custom_error($ResponseMessage);
            return $check_success;
        }
    }
}
