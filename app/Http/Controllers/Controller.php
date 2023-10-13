<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function destroyModel(Model $model)
    {
        $modelName = getModelName(class_basename($model));
        try {
            $model->delete();
        } catch (Exception $e) {
            return $this->respondWithError("Failed to delete $modelName", $e);
        }

        return response()->json([
            'message' => "$modelName deleted successfully"
        ]);
    }

    public function respondWithError(string $message, Exception $e)
    {
        return response()->json([
            'message' => $message,
            'error' => $e->getMessage()
        ]);
    }
}
