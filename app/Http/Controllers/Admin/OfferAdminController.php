<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Qvm\ProductController;
use App\Http\Requests\StoreOfferAdminRequest;
use App\Http\Requests\UpdateOfferAdminRequest;
use App\Http\Traits\ApiTrait;
use App\Http\Traits\QVMTrait;
use App\Models\Offer;
use App\Models\OfferDetail;
use App\Models\OfferSpecification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class OfferAdminController extends Controller
{
    use ApiTrait;
    use QVMTrait;
    public function elapsed_time_percentage($offer_id)
    {
        $offer = Offer::find($offer_id);
        if (!$offer) {
            return 0;
        }
        $startDate = Carbon::parse($offer->created_at);
        $endDate = Carbon::parse($offer->offer_expiry_date);
        $currentDate = Carbon::now();
        $totalTime = $endDate->diffInMinutes($startDate);
        $elapsedTime = $currentDate->diffInMinutes($startDate);
        if ($totalTime == 0) {
            return 0;
        }
        $percent = ($elapsedTime / $totalTime) * 100;
        if ($percent > 100) {
            return 100;
        }
        return round($percent, 2);
//         $startDate = '08/01/2015 12:00:00';
// $endDate = '09/01/2015 12:00:00';
// $startDate = new DateTime($startDate);
// $currentDate = new DateTime(); // defaults to now
// $endDate = new DateTime($endDate);
// $totalTime = $endDate->diff($startDate)->format('%a');
// $elapsedTime = $currentDate->diff($startDate)->format('%a');
// // diff returns a DateInterval object; calling its format method
// // with %a returns the number of days in the interval
// $percent = ($elapsedTime / $totalTime) * 100;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $Offers = Offer::with('offer_type', 'offer_details', 'offer_specifications')->orderby('id', 'DESC')->get();
        $product_ids = [];
        foreach ($Offers as $Offer) {
            foreach ($Offer->offer_details as $offer_detail) {
                $product_ids[] = $offer_detail->product_id;
            }
        }
        $ProductController = new ProductController();
        $products_by_product_ids = $ProductController->products_by_product_ids($product_ids);
        foreach ($Offers as $Offer) {
            foreach ($Offer->offer_details as $offer_detail) {
                $product = (isset($products_by_product_ids[$offer_detail->product_id])) ? $products_by_product_ids[$offer_detail->product_id] : null;
                $offer_detail->product = $product;
            }
        }
//         $newdata = [0 => 'My custom data here'];
// $custom = collect(['data' => $newdata]);
// $data = $custom->merge($Offers);
// return $data ;
//         if(isset($Offers['total']) && $Offers['total'] >= 1){
//            foreach($Offers['data'] as $key => $offerData){
//              $offerData['elapsed_time_percentage'] = $this->elapsed_time_percentage($offerData->id);
//            }
//         }
        $ResponseMessage = __("data retrieved successfully");
        $check_success = $this->check_success($ResponseMessage, $Offers);
        return $check_success;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOfferAdminRequest $request)
    {
        $path = Storage::disk('public')->put('images', $request->file('image'));
        $Offer = new Offer();
        $Offer->image = 'storage/' . $path;
        $Offer->offer_title = $request->offer_title;
        $Offer->seller_id = $request->seller_id;
        $Offer->minimum_order_quantity = $request->minimum_order_quantity;
        $Offer->minimum_order_amount = $request->minimum_order_amount;
        $Offer->offer_expiry_date = $request->offer_expiry_date;
        $Offer->offer_type_id = $request->offer_type_id;
        $Offer->save();
        foreach ($request->offer_specifications as $offer_specification) {
            $specification = $offer_specification['offer_specification'];
            $new_offer_specification = new OfferSpecification();
            $new_offer_specification->offer_id = $Offer->id;
            $new_offer_specification->offer_specification = $specification;
            $new_offer_specification->save();
        }
        foreach ($request->offer_details as $offer_detail) {
            $product_id = $offer_detail['product_id'];
            $offer_price = $offer_detail['offer_price'];
            $offer_quantity = $offer_detail['offer_quantity'];
            $minimum_order_quantity = $offer_detail['minimum_order_quantity'];
            $maximum_order_quantity = $offer_detail['maximum_order_quantity'];
            $offer_detail = new OfferDetail();
            $offer_detail->offer_id = $Offer->id;
            $offer_detail->product_id = $product_id;
            $offer_detail->offer_quantity = $offer_quantity;
            $offer_detail->offer_price = $offer_price;
            $offer_detail->minimum_order_quantity = $minimum_order_quantity;
            $offer_detail->maximum_order_quantity = $maximum_order_quantity;
            $offer_detail->save();
        }
        $Offer = Offer::with(['offer_type', 'offer_details', 'offer_specifications'])->find($Offer->id);
        $Offer->elapsed_time_percentage = $this->elapsed_time_percentage($Offer->id);
        $ResponseMessage = __("data stored successfully");
        $check_success = $this->check_success($ResponseMessage, $Offer);
        return $check_success;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Offer = Offer::with(['offer_type', 'offer_details', 'offer_specifications'])->find($id);
        if (!$Offer) {
            $ResponseMessage = __("Data not found");
            return $this->custom_error($ResponseMessage);
        }
        $product_ids = [];
        foreach ($Offer->offer_details as $offer_detail) {
            $product_ids[] = $offer_detail->product_id;
        }
        $ProductController = new ProductController();
        $products_by_product_ids = $ProductController->products_by_product_ids($product_ids);
        foreach ($Offer->offer_details as $offer_detail) {
            $product = (isset($products_by_product_ids[$offer_detail->product_id])) ? $products_by_product_ids[$offer_detail->product_id] : null;
            $offer_detail->product = $product;
        }
        $Offer->elapsed_time_percentage = $this->elapsed_time_percentage($Offer->id);
        $ResponseMessage = __("data retrieved successfully");
        $check_success = $this->check_success($ResponseMessage, $Offer);
        return $check_success;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOfferAdminRequest $request, $id)
    {
        $Offer = Offer::find($id);
        if (!$Offer) {
            $ResponseMessage = __("Data not found");
            return $this->custom_error($ResponseMessage);
        }
        if (isset($request->image)) {
            $path = Storage::disk('public')->put('images', $request->file('image'));
            $Offer->image = 'storage/' . $path;
        }
        if (isset($request->minimum_order_quantity)) {
            $Offer->minimum_order_quantity = $request->minimum_order_quantity;
        }
        if (isset($request->minimum_order_amount)) {
            $Offer->minimum_order_amount = $request->minimum_order_amount;
        }
        if (isset($request->offer_title)) {
            $Offer->offer_title = $request->offer_title;
        }
        if (isset($request->seller_id)) {
            $Offer->seller_id = $request->seller_id;
        }
        if (isset($request->offer_expiry_date)) {
            $Offer->offer_expiry_date = $request->offer_expiry_date;
        }
        if (isset($request->offer_type_id)) {
            $Offer->offer_type_id = $request->offer_type_id;
        }
        $Offer->update();
        if (isset($request->offer_details) && is_array($request->offer_details)) {
            OfferDetail::whereOfferId($Offer->id)->delete();
            foreach ($request->offer_details as $offer_detail) {
                $product_id = $offer_detail['product_id'];
                $offer_price = $offer_detail['offer_price'];
                $offer_quantity = $offer_detail['offer_quantity'];
                $minimum_order_quantity = $offer_detail['minimum_order_quantity'];
                $maximum_order_quantity = $offer_detail['maximum_order_quantity'];
                $offer_detail = new OfferDetail();
                $offer_detail->offer_id = $Offer->id;
                $offer_detail->product_id = $product_id;
                $offer_detail->offer_quantity = $offer_quantity;
                $offer_detail->offer_price = $offer_price;
                $offer_detail->minimum_order_quantity = $minimum_order_quantity;
                $offer_detail->maximum_order_quantity = $maximum_order_quantity;
                $offer_detail->save();
            }
        }
        if (isset($request->offer_specifications) && is_array($request->offer_specifications)) {
            OfferSpecification::whereOfferId($Offer->id)->delete();
            foreach ($request->offer_specifications as $offer_specification) {
                $specification = $offer_specification['offer_specification'];
                $new_offer_specification = new OfferSpecification();
                $new_offer_specification->offer_id = $Offer->id;
                $new_offer_specification->offer_specification = $specification;
                $new_offer_specification->save();
            }
        }
        $Offer = Offer::with(['offer_type', 'offer_details', 'offer_specifications'])->find($Offer->id);
        $Offer->elapsed_time_percentage = $this->elapsed_time_percentage($Offer->id);
        // $Offer->start_time = Carbon::parse($Offer->created_at)->format("Y-m-d h:i:s");
        // $Offer->end_time = Carbon::parse($Offer->offer_expiry_date)->format("Y-m-d h:i:s");
        // $Offer->now = Carbon::now()->format("Y-m-d h:i:s");
        $ResponseMessage = __("data retrieved successfully");
        $check_success = $this->check_success($ResponseMessage, $Offer);
        return $check_success;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Offer = Offer::find($id);
        if (!$Offer) {
            $ResponseMessage = __("Data not found");
            return $this->custom_error($ResponseMessage);
        }
        $Offer->delete();
        $ResponseMessage = __("data deleted successfully");
        $check_success = $this->custom_success($ResponseMessage);
        return $check_success;
    }
}
