<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;


final class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
        $this->reportable(function (Throwable $exception) {
            $message = method_exists($exception, 'getMessage') ? $exception->getMessage() : 'An error occurred. Please try again later.';
            Log::error($exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => $message,
            ], 500);
        });
    }
    public function render($request, Throwable $exception)
    {
        Log::error($exception->getMessage());

        if ($exception instanceof ValidationException) {
            return response()->json([
                'success' => false,
                'message' => 'The given data was invalid.',
                'errors' => $exception->validator->errors(),
            ], 422);
        } else if ($exception instanceof QueryException && $exception->getCode() === '23000') {
            // Check if the error message contains the foreign key constraint violation code
            if ($this->containsForeignKeyError($exception->getMessage())) {
                return new JsonResponse([
                    'success' => false,
                    'message' => 'Foreign key constraint violation.',
                ], 422);
            }
        } else if ($exception instanceof NotFoundHttpException) {
            // Handle the case where a route is not found
            return response()->json([
                'success' => false,
                'message' => 'Route not found.',
            ], 404);
        } else if ($exception instanceof ModelNotFoundException) {
            // Handle the "No query results for model" exception here
            return response()->json([
                'success' => false,
                'message' => 'Resource not found'
            ], 404);
        }
        $message = method_exists($exception, 'getMessage') ? $exception->getMessage() : 'An error occurred. Please try again later.';
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
            ], 500);
        }
        return new JsonResponse([
            'success' => false,
            'message' => $message,
        ], 500);
    }
    private function containsForeignKeyError($errorMessage)
    {
        Log::error($errorMessage);

        return strpos($errorMessage, 'foreign key constraint fails') !== false;
    }
   
}
