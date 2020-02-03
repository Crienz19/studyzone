<?php

namespace App\Http\Controllers\Api;

use App\Amenities;
use App\Http\Controllers\Controller;
use App\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function getAllDailyService()
    {
        return Service::whereDate('created_at', Carbon::now()->timezone('Asia/Manila')->toDateString())
            ->orderBy('created_at', 'desc')
            ->with('amenities')
            ->get()
            ->map
            ->format();
    }

    public function getOverallService()
    {
        return Service::orderBy('created_at', 'desc')
            ->with('amenities')
            ->get()
            ->map
            ->format();
    }

    public function storeService(Request $request)
    {
        $request->validate([
            'amenities'     =>  'required',
            'quantity'      =>  'required'
        ]);

        Service::create([
            'amenities_id'  =>  $request->input('amenities'),
            'quantity'      =>  $request->input('quantity'),
            'total'         =>  Amenities::find($request->input('amenities'))->price * $request->input('quantity')
        ]);

        return response()->json([
            'message'   =>  'Service Added!'
        ]);
    }
}
