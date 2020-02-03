<?php

namespace App\Http\Controllers\Api;

use App\Card;
use App\Http\Controllers\Controller;
use App\Notifications\NewTransactionNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function getAllCards()
    {
        return Card::orderBy('created_at', 'desc')
            ->get()
            ->map
            ->format();
    }

    public function storeCard(Request $request)
    {
        $dt = Carbon::now()->timezone('Asia/Manila');
        switch ($request->input('type')) {
            case 'DC':
                Card::create([
                    'control_no'        =>  $request->input('control_no'),
                    'type'              =>  $request->input('type'),
                    'date_activated'    =>  $dt->toDateTimeString(),
                    'date_expired'      =>  $dt->addCentury(),
                    'discount'          =>  10,
                    'price'             =>  100,
                    'status'            =>  true
                ]);

                return response()->json([
                    'message'   =>  'Card Registered!'
                ]);
                break;

            case 'AAC':
                Card::create([
                    'control_no'        =>  $request->input('control_no'),
                    'type'              =>  $request->input('type'),
                    'date_activated'    =>  $dt->toDateTimeString(),
                    'date_expired'      =>  $dt->addMonths(5),
                    'discount'          =>  100,
                    'price'             =>  0,
                    'status'            =>  true
                ]);

                return response()->json([
                    'message'   =>  'Card Registered!'
                ]);
                break;
        }
    }

    public function deleteCard($id)
    {
        Card::where('id', $id)->delete();

        return response()->json([
            'message'   =>  'Card deleted'
        ]);
    }
}
