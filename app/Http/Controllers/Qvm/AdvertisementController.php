<?php
namespace App\Http\Controllers\Qvm;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdvertisementRequest;
use App\Http\Requests\UpdateAdvertisementRequest;
use App\Http\Traits\ApiTrait;
use App\Http\Traits\QVMTrait;
use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class AdvertisementController extends Controller
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

        // auth & lang
        $subscriber_id = Auth::id();
        $lang = (isset($request->lang)) ? $request->lang : 'ar';
        App::setLocale($lang);
        // auth and lang

        $advertisements = Advertisement::orderby('sorting')->whereIsActive(1)->paginate(10);
        $ResponseMessage = __("advertisements retrieved successfully");
        $check_success = $this->check_success($ResponseMessage, $advertisements);
        return $check_success;
    }

    public function advertisements_top()
    {
        $advertisements = Advertisement::wherePosition('top')->orderby('sorting')->whereIsActive(1)->paginate(10);
        $ResponseMessage = __("advertisements retrieved successfully");
        $check_success = $this->check_success($ResponseMessage, $advertisements);
        return $check_success;
        
    }

    public function advertisements_medium()
    {
        $advertisements = Advertisement::wherePosition('medium')->orderby('sorting')->whereIsActive(1)->paginate(10);
        $ResponseMessage = __("advertisements retrieved successfully");
        $check_success = $this->check_success($ResponseMessage, $advertisements);
        return $check_success;
    }

    public function advertisements_bottom()
    {
        $advertisements = Advertisement::wherePosition('bottom')->orderby('sorting')->whereIsActive(1)->paginate(10);
        $ResponseMessage = __("advertisements retrieved successfully");
        $check_success = $this->check_success($ResponseMessage, $advertisements);
        return $check_success;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAdvertisementRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdvertisementRequest $request)
    {
        //
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function show(Advertisement $advertisement)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function edit(Advertisement $advertisement)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAdvertisementRequest  $request
     * @param  \App\Models\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdvertisementRequest $request, Advertisement $advertisement)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Advertisement $advertisement)
    {
        //
    }
}
