<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse; // Importa JsonResponse para respuestas JSON a la API
use Illuminate\Http\Request; // Para manejar errores de validación específicamente
use Illuminate\Validation\ValidationException; // Para 404 Not Found
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
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
     */
    public function register(): void
    {
        // Esto captura cualquier excepción
        $this->renderable(function (Throwable $e, Request $request) {
            // Verificar si la petición es una petición de API
            if ($request->expectsJson() || $request->is('api/*')) {
                $response = [];
                $statusCode = 500; // Por defecto, un error interno del servidor

                // --- Manejo específico de errores ---

                // Errores de validación (por ejemplo, de Form Requests o validator)
                if ($e instanceof ValidationException) {
                    $statusCode = 422; // Unprocessable Entity
                    $response = [
                        'message' => 'Los datos proporcionados no son válidos.',
                        'errors' => $e->errors(),
                    ];
                }
                // Recursos no encontrados (ej. modelo no encontrado por findOrFail, o ruta 404)
                elseif ($e instanceof NotFoundHttpException) {
                    $statusCode = 404; // Not Found
                    $response = [
                        'message' => 'El recurso solicitado no fue encontrado.',
                    ];
                }

                // Si no se manejó específicamente, es un error del servidor
                if (empty($response)) {
                    $response['message'] = $e->getMessage(); // Mensaje de la excepción

                    if (config('app.debug')) {
                        $response['exception'] = get_class($e);
                        $response['file'] = $e->getFile();
                        $response['line'] = $e->getLine();
                        $response['trace'] = $e->getTrace();
                    } else {
                        $response['message'] = 'Ha ocurrido un error inesperado.';
                    }
                }

                return new JsonResponse($response, $statusCode);
            }
        });
    }
}
