<?php

namespace App\Exceptions;

use App\Http\Traits\ApiResponse;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{

    use ApiResponse;

    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }


    public function render($request, Throwable $e)
    {
        // If Request is a JSON
        if($request->wantsJson()) {
            // HTTP Exception -> Page Not Found
            if($e instanceof NotFoundHttpException) {
                return $this->errorResponse(__('messages.page_not_found'), [], $e->getStatusCode());
            }
            // Method Not Allow Exception
            if ($e instanceof MethodNotAllowedHttpException) {
                return $this->errorResponse($e->getMessage(), [], $e->getStatusCode());
            }
            // Validation Errors
            if($e instanceof ValidationException) {
                $errors = $this->convertValidationExceptionToResponse($e, $request);
                return $this->errorResponse('error', $errors->getOriginalContent(), $e->status);
            }
        }

        // JWT Exception
        if ($e instanceof \Tymon\JWTAuth\Exceptions\JWTException) {

            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return $this->errorResponse('TOKEN_EXPIRED', [], 401);

            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return $this->errorResponse('TOKEN_INVALID', [], 401);

            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenBlacklistedException) {
                return $this->errorResponse('TOKEN_BLACKLISTED', [], 401);

            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\JWTException) {
                return $this->errorResponse('TOKEN_ABSENT', [], 401);
            }
            if ($e->getMessage() === 'Token not provided') {
                return $this->errorResponse('Token not provided', [], 401);
            }
        }

        return parent::render($request, $e);
    }
}
