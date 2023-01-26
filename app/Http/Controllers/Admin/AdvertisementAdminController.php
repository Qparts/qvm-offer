<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdvertisementRequest;
use App\Http\Requests\UpdateAdvertisementRequest;
use App\Http\Traits\ApiTrait;
use App\Http\Traits\QVMTrait;
use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdvertisementAdminController extends Controller
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
        $advertisements = Advertisement::where(function ($q) use ($data) {
            if (isset($data['position'])) {
                return $q->where('position', $data['position']);
            }

            if (isset($data['is_active'])) {
                return $q->where('is_active', $data['is_active']);
            }

        })->paginate(10);
        $ResponseMessage = __("data retrieved successfully");
        $check_success = $this->check_success($ResponseMessage, $advertisements);
        return $check_success;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdvertisementRequest $request)
    {
        $path = Storage::disk('public')->put('images', $request->file('image'));
        $advertisement = new Advertisement();
        $advertisement->image = 'storage/' . $path;
        $advertisement->position = $request->position;
        $advertisement->save();
        $ResponseMessage = __("data stored successfully");
        $check_success = $this->check_success($ResponseMessage, $advertisement);
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
        $advertisement = Advertisement::find($id);
        if (!$advertisement) {
            $ResponseMessage = __("Data not found");
            return $this->custom_error($ResponseMessage);
        }
        $ResponseMessage = __("data retrieved successfully");
        $check_success = $this->check_success($ResponseMessage, $advertisement);
        return $check_success;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdvertisementRequest $request, $id)
    {
        $advertisement = Advertisement::find($id);
        if (!$advertisement) {
            $ResponseMessage = __("Data not found");
            return $this->custom_error($ResponseMessage);
        }
        if (isset($request->image)) {
            $path = Storage::disk('public')->put('images', $request->file('image'));
            $advertisement->image = 'storage/' . $path;
        }
        if (isset($request->position)) {
            $advertisement->position = $request->position;
        }
        if (isset($request->is_active)) {
            $advertisement->is_active = $request->is_active;
        }
        if (isset($request->sorting)) {
            $advertisement->sorting = $request->sorting;
        }

        $advertisement->update();

        $ResponseMessage = __("data retrieved successfully");
        $check_success = $this->check_success($ResponseMessage, $advertisement);
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
        $advertisement = Advertisement::find($id);
        if (!$advertisement) {
            $ResponseMessage = __("Data not found");
            return $this->custom_error($ResponseMessage);
        }

        $advertisement->delete();
        $ResponseMessage = __("data deleted successfully");
        $check_success = $this->custom_success($ResponseMessage);
        return $check_success;
    }
}
