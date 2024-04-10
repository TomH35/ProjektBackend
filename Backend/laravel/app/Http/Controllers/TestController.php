<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Phone;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function testPost()
    {
        $response = [
            'status' => 200,
            'message' => "ok",
        ];

        return response()->json($response);
    }

}