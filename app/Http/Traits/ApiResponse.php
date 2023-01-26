<?php


namespace App\Http\Traits;


use Illuminate\Http\Response;

trait ApiResponse
{

    /**
     * Return success message
     * @param $data
     * @param string|null $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($data, string $message = 'success', int $statusCode = Response::HTTP_OK)
    {
        $response = [
            'status' => true,
            'status_code' => $statusCode,
            'message' => $message,
            'data'    => $data,
        ];

        return response()->json($response, $statusCode);
    }


    /**
     * Return Error Message
     * @param string $message
     * @param array $errors
     * @param int|int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse(string $message = 'error', array $errors = [], int $statusCode = Response::HTTP_FORBIDDEN)
    {
        // Set array response data
        $response = [
            'status' => false,
            'status_code' => $statusCode,
            'message' => $message,
            'data' => $errors,
        ];

        // return response data
        return response()->json($response, $statusCode);
    }


    public function throwException($message = 'error')
    {
        throw new \ErrorException($message);
    }

}
