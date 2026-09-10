<?php

namespace App\Exceptions;

use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
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
        //
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
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if( $request->is('api/*')){
            // Format Validation Response
            if ($exception instanceof ValidationException) {
                return response()->json([
                    'errors' => $exception->errors(),
                    'success' => false,
                    'status' => 422,
                    'message' => Response::$statusTexts[422]
                ], $exception->status);
            }
            if (env('APP_DEBUG')) {
                $response['error']['trace'] = $exception->getTrace();
            }
            $status = Response::HTTP_INTERNAL_SERVER_ERROR;
            if ($exception instanceof \HttpResponseException) {
                $status = Response::HTTP_INTERNAL_SERVER_ERROR;
            } elseif ($exception instanceof MethodNotAllowedHttpException) {
                $status = Response::HTTP_METHOD_NOT_ALLOWED;
                $exception = new MethodNotAllowedHttpException([], 'HTTP_METHOD_NOT_ALLOWED', $exception);
            } elseif ($exception instanceof NotFoundHttpException) {
                $status = Response::HTTP_NOT_FOUND;
                $exception = new NotFoundHttpException('HTTP_NOT_FOUND', $exception);
            } elseif ($exception instanceof AuthorizationException) {
                $status = Response::HTTP_FORBIDDEN;
                $exception = new AuthorizationException('HTTP_FORBIDDEN', $status);
            } elseif ($exception instanceof \Dotenv\Exception\ValidationException && $exception->getResponse()) {
                $status = Response::HTTP_BAD_REQUEST;
                $exception = new \Dotenv\Exception\ValidationException('HTTP_BAD_REQUEST', $status, $exception);
            }
            return response()->json([
                'success' => false,
                'status' => $status,
                'message' => $exception->getMessage()
            ], $status);
        }
        return parent::render($request, $exception);
    }

}
