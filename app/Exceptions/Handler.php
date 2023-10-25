<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            preg_match('/\[(.*?)\]/', $e->getMessage(), $matches);

            $model = str_replace('Spatie\Permission', 'App', $matches[1]);

            $model = getModelName(substr($model, 11));

            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json(["message" => "$model not found"], 404);
            }
        });
    }
}
