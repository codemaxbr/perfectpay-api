<?php

namespace App\Http\Controllers;

use Exception;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Response;

class Controller extends BaseController
{
    public function responseOk($data)
    {
        return response()->json($data, Response::HTTP_OK);
    }

    public function responseError(Exception $e)
    {
        $statusCode = in_array($e->getCode(), array_keys(Response::$statusTexts)) ? $e->getCode() : Response::HTTP_INTERNAL_SERVER_ERROR;
        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ], $statusCode);
    }
}
