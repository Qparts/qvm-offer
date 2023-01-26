<?php
namespace App\Http\Traits;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
trait ApiTrait
{
    public function __construct()
    {
        header("Access-Control-Allow-Origin: *");
    }
    public $successStatus = 200;
    public function check_failure($all_request, $conditions = [])
    {
        $validator = Validator::make($all_request, $conditions);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $ResponseMessage = $this->validationErrorsToString($errors);
            //failure or success
            $this->successStatus = Response::HTTP_FORBIDDEN;
            $response = [
                'status' => false,
                'status_code' => $this->successStatus,
                'message' => $ResponseMessage,
                'data' => $errors,
            ];
            return response()->json($response, $this->successStatus);
            // return response()->json([
            //     'ResponseCode' => 0
            //     , 'ResponseStatus' => 'failure'
            //     , 'ResponseMessage' => $ResponseMessage
            //     , 'data' => $errors], $this->successStatus);
        }
        return false;
    }
    public function check_success($ResponseMessage, $data)
    {
        $response = [
            'status' => true,
            'status_code' => $this->successStatus,
            'message' => $ResponseMessage,
            'data' => $data,
        ];
        return response()->json($response, $this->successStatus);
        // return response()->json([
        //     'ResponseCode' => 1
        //     , 'ResponseStatus' => 'success'
        //     , 'ResponseMessage' => $ResponseMessage
        //     , 'data' => $data], $this->successStatus);
    }
    public function custom_success($ResponseMessage)
    {
        return response()->json([
            'ResponseCode' => 1
            , 'ResponseStatus' => 'success'
            , 'ResponseMessage' => $ResponseMessage
            , 'data' => []], $this->successStatus);
    }
    public function custom_error($ResponseMessage)
    {

        $this->successStatus = Response::HTTP_FORBIDDEN;

        $response = [
            'status' => false,
            'status_code' => $this->successStatus,
            'message' => $ResponseMessage,
            'data' => [],
        ];
        return response()->json($response, $this->successStatus);

        // return response()->json([
        //     'ResponseCode' => 0
        //     , 'ResponseStatus' => 'error'
        //     , 'ResponseMessage' => $ResponseMessage
        //     , 'data' => []], $this->successStatus);


    }
    public function validationErrorsToString($errArray)
    {
        $valArr = array();
        foreach ($errArray->toArray() as $key => $value) {
            $errStr = $value[0];
            array_push($valArr, $errStr);
        }
        if (!empty($valArr)) {
            $errStrFinal = implode(',', $valArr);
        }
        return $errStrFinal;
    }
}
