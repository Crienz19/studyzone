<?php

namespace App\Http\Controllers\Api;

use App\Amenities;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AmenitiesController extends Controller
{
    public function getAllAmenities()
    {
        return Amenities::orderBy('created_at', 'desc')
            ->get()
            ->map
            ->format();
    }

    public function storeAmenities(Request $request)
    {
        $request->validate([
            'name'  =>  'required',
            'price' =>  'required'
        ]);

        Amenities::create([
            'name'  =>  $request->input('name'),
            'price' =>  $request->input('price')
        ]);

        return response()->json([
            'message'   =>  'Store Inserted!'
        ]);
    }

    public function deleteAmenities($id)
    {
        Amenities::find($id)->delete();

        return response()->json([
            'message'   =>  'Amenities Destroyed'
        ], 200);
    }
}
