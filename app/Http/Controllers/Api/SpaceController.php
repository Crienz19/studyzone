<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Space;
use Illuminate\Http\Request;

class SpaceController extends Controller
{
    public function getAll()
    {
        $space = Space::orderBy('id', 'asc')
            ->get()
            ->map
            ->format();

        return response()->json($space);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          =>  'required',
            'description'   =>  'required',
            'rate'          =>  'required'
        ]);

        Space::create([
            'name'          =>  $request->input('name'),
            'description'   =>  $request->input('description'),
            'rate'          =>  $request->input('rate'),
            'daily_rate'    =>  $request->input('daily_rate'),
            'weekly_rate'   =>  $request->input('weekly_rate'),
            'monthly_rate'  =>  $request->input('monthly_rate'),
            'capacity'      =>  $request->input('capacity'),
            'image'         =>  ''
        ]);

        return response()->json([
            'message'   =>  'Space Added!'
        ]);
    }

    public function update(Request $request, $id)
    {
        Space::where('id', $id)->update([
            'name'          =>  $request->input('name'),
            'description'   =>  $request->input('description'),
            'rate'          =>  $request->input('rate'),
            'daily_rate'    =>  $request->input('daily_rate'),
            'weekly_rate'   =>  $request->input('weekly_rate'),
            'monthly_rate'  =>  $request->input('monthly_rate'),
            'capacity'      =>  $request->input('capacity'),
            'image'         =>  ''
        ]);

        return response()->json([
            'message'   =>  'Space Updated'
        ]);
    }

    public function destroy($id)
    {
        Space::where('id', $id)->delete();

        return response()->json([
            'message'   =>  'Space Deleted'
        ]);
    }
}
