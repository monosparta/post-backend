<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Broadcasting\BroadcastException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Laravel\Passport\Exceptions\OAuthServerException;
use Prettus\Validator\Exceptions\ValidatorException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [

    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
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
        $this->renderable(function (QueryException $exception, $request) {
            \Log::error('=== QueryException ===');
            \Log::error($exception->getMessage());

            return response()->json([
                'success' => false,
                'statusCode' => 500,
                'errorCode' => 0,
                'message' => 'Internal Server Error',
            ], 500);
        });

        $this->renderable(function (ModelNotFoundException $exception, $request) {
            \Log::error('=== ModelNotFoundException ===');
            \Log::error($exception->getMessage());

            return response()->json([
                'success' => false,
                'statusCode' => 404,
                'errorCode' => 0,
                'message' => 'Requested resource not found',
            ], 404);
        });

        $this->renderable(function (NotFoundHttpException $exception, $request) {
            \Log::error('=== NotFoundHttpException ===');
            \Log::error($exception->getMessage());

            return response()->json([
                'success' => false,
                'statusCode' => 404,
                'errorCode' => 0,
                'message' => 'Requested resource not found',
            ], 404);
        });

        $this->renderable(function (ValidationException $exception, $request) {
            \Log::error('=== ValidatorException: The given data did not pass validation ===');
            \Log::error($exception->errors());

            return response()->json([
                'success' => false,
                'statusCode' => 400,
                'errorCode' => 400,
                'message' => __('clientResponse.badRequest.invalid_parameter'),
                'errors' => $exception->errors(),
            ], 400);
        });

        $this->renderable(function (ValidatorException $exception, $request) {
            \Log::error('=== ValidatorException: The given data did not pass validation ===');
            \Log::error($exception->getMessageBag());

            return response()->json([
                'success' => false,
                'statusCode' => 400,
                'errorCode' => 400,
                'message' => __('clientResponse.badRequest.invalid_parameter'),
                'errors' => $exception->getMessageBag(),
            ], 400);
        });

        $this->renderable(function (UnauthorizedException $exception, $request) {
            $message = $exception->getMessage() ?? __('clientResponse.account.login.error_unauthorized');
            \Log::error('=== UnauthorizedException ===');
            \Log::error($message);

            return response()->json([
                'success' => false,
                'statusCode' => 401,
                'errorCode' => 0,
                'message' => $message,
            ], 401);
        });

        $this->renderable(function (AuthenticationException $exception, $request) {
            $message = $exception->getMessage() ?? __('clientResponse.account.login.error_unauthorized');
            \Log::error('=== AuthenticationException ===');
            \Log::error($message);

            return response()->json([
                'success' => false,
                'statusCode' => 401,
                'errorCode' => 0,
                'message' => $message,
            ], 401);
        });

        $this->renderable(function (AuthorizationException $exception, $request) {
            $message = $exception->getMessage() ?? __('clientResponse.account.login.error_unauthorized');
            \Log::error('=== AuthorizationException ===');
            \Log::error($message);

            return response()->json([
                'success' => false,
                'statusCode' => 401,
                'errorCode' => 0,
                'message' => $message,
            ], 401);
        });

        $this->renderable(function (OAuthServerException $exception, $request) {
            $message = $exception->getMessage() ?? __('clientResponse.account.login.error_unauthorized');
            \Log::error('=== OAuthServerException ===');
            \Log::error($message);

            return response()->json([
                'success' => false,
                'statusCode' => 401,
                'errorCode' => $exception->getCode(),
                'message' => $message,
            ], 401);
        });

        $this->renderable(function (HttpException $exception, $request) {
            $message = $exception->getMessage();
            if ('Your email address is not verified.' == $message) {
                return response()->json([
                    'success' => false,
                    'statusCode' => 403,
                    'errorCode' => 0,
                    'message' => $message,
                ], 403);
            }
        });

        $this->renderable(function (BroadcastException $exception, $request) {
            $message = $exception->getMessage();
            \Log::error('=== BroadcastException ===');
            \Log::error($message);

            return response()->json([
                'success' => false,
                'statusCode' => 500,
                'errorCode' => 0,
                'message' => $message,
            ], 500);
        });

        $this->renderable(function (InvalidSignatureException $exception, $request) {
            $message = $exception->getMessage();
            \Log::error('=== InvalidSignatureException ===');
            \Log::error($message);

            return response()->json([
                'success' => false,
                'statusCode' => 403,
                'errorCode' => 0,
                'message' => 'An exception class that is raised when signature is invalid.',
            ], 403);
        });

        $this->renderable(function (InvalidEventRequestException $exception, $request) {
            $message = $exception->getMessage();
            \Log::error('=== InvalidEventRequestException ===');
            \Log::error($message);

            return response()->json([
                'success' => false,
                'statusCode' => 403,
                'errorCode' => 0,
                'message' => 'An exception class that is raised when received invalid event request.',
            ], 403);
        });
    }

    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        return parent::render($request, $exception);
    }
}
