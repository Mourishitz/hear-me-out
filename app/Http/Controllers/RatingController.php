<?php

namespace App\Http\Controllers;

use App\Http\Services\RatingService;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function like(int $id, Request $request)
    {
        return response()->json([
            'message' => 'Not implemented',
        ], 501);
    }

    public function unlike()
    {
        return response()->json([
            'message' => 'Not implemented',
        ], 501);
    }

    public function getById($id)
    {
        return Rating::query()->findOrFail($id);
    }

    public function update($id)
    {
        return response()->json([
            'message' => 'Not implemented',
        ], 501);
    }

    public function delete($id)
    {
        return RatingService::getModel($id)->delete();
    }
}
