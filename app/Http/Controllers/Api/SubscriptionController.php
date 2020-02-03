<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Space;
use App\Subscription;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function getAllSubscription()
    {
        return response()->json(Subscription::orderBy('created_at', 'desc')
            ->with('user')
            ->with('space')
            ->get()
            ->map
            ->format());
    }

    public function addSubscription(Request $request, $userId)
    {
        $request->validate([
            'subscription_code'     =>  'required',
            'subscription_space'    =>  'required',
            'subscription_plan'     =>  'required'
        ]);

        $dt = Carbon::now()->timezone('Asia/Manila');

        switch ($request->input('subscription_plan')) {
            case 'WSP':
                Subscription::create([
                    'subscription_code'     =>  $request->input('subscription_code'),
                    'space_id'              =>  $request->input('subscription_space'),
                    'user_id'               =>  $userId,
                    'plan'                  =>  'Week Plan',
                    'date_registered'       =>  $dt->toDateTimeString(),
                    'date_expired'          =>  $dt->addWeek()->toDateTimeString(),
                    'price'                 =>  Space::find($request->input('subscription_space'))->weekly_rate,
                    'status'                =>  1
                ]);
                break;

            case 'MSP':
                Subscription::create([
                    'subscription_code'     =>  $request->input('subscription_code'),
                    'space_id'              =>  $request->input('subscription_space'),
                    'user_id'               =>  $userId,
                    'plan'                  =>  'Month Plan',
                    'date_registered'       =>  $dt->toDateTimeString(),
                    'date_expired'          =>  $dt->addMonth()->toDateTimeString(),
                    'price'                 =>  Space::find($request->input('subscription_space'))->monthly_rate,
                    'status'                =>  1
                ]);
                break;
        }

        return response()->json([
            'message'   =>  'Subscription Added To ' . User::find($userId)->name
        ]);
    }

    public function deleteSubscription($id)
    {
        Subscription::where('id', $id)->delete();

        return response()->json([
            'message'   =>  'Subscription Deleted.'
        ]);
    }
}
