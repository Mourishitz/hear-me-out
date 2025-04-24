<?php

namespace App\Http\Exceptions;

use Illuminate\Http\JsonResponse;

class ControllerException extends BaseException
{
    public function render(): JsonResponse
    {
        return response()->json($this->getMessage(), $this->getCode());
    }
}
