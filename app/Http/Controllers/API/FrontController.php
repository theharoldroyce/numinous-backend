<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Events;
class FrontController extends Controller
{
    //
    public function upevent()
    {
        $upevent = Events::where('status', '0')->get();
    return response()->json([
        'status' =>200,
        'upevent' => $upevent
    ]);
    }
}
