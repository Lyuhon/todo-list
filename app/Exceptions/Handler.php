<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    // Список исключений которые не нудно логировать 
    protected $dontReport = [
        AuthenticationException::class,
        ValidationException::class,
        ModelNotFoundException::class,
        NotFoundHttpException::class,
        AccessDeniedHttpException::class,
    ];

    // Список входных данных которые не нужно отображать в исключениях
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    // Обработчик ошибок и исключений
    public function render($request, Throwable $exception): JsonResponse
    {
        
        if ($exception instanceof ValidationException) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $exception->errors(),
            ], 422);
        }

        if ($exception instanceof AuthenticationException) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'You must be authenticated to access this resource.'
            ], 401);
        }

        if ($exception instanceof AccessDeniedHttpException) {
            return response()->json([
                'error' => 'Forbidden',
                'message' => 'You do not have permission to perform this action.'
            ], 403);
        }

        if ($exception instanceof ModelNotFoundException || $exception instanceof NotFoundHttpException) {
            return response()->json([
                'error' => 'Not Found',
                'message' => 'The requested resource was not found.'
            ], 404);
        }

        // Любая другая ошибка (500)
        return response()->json([
            'error' => 'Server Error',
            'message' => $exception->getMessage()
        ], 500);
    }
}