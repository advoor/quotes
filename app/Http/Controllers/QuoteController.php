<?php

namespace App\Http\Controllers;

use App\Services\Quote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        if ($request->has('fresh')) {
            Quote::refresh();
        }

        return response()->json(Quote::get());
    }
}
