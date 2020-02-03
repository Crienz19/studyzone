<?php

namespace App\Http\Controllers\Api;

use App\Card;
use App\Events\NewTransactionAdded;
use App\Http\Controllers\Controller;
use App\Space;
use App\Subscription;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function addTransaction(Request $request)
    {
        $dt = \Carbon\Carbon::now()->setTimezone('Asia/Manila');

        switch ($request->input('type')) {
            case 'regular':
                if ($request->input('discount')) {
                    $request->validate([
                        'space_id'      =>  'required',
                        'duration'      =>  'required',
                        'control_no'    =>  'required'
                    ]);
                } else {
                    $request->validate([
                        'space_id'      =>  'required',
                        'duration'      =>  'required'
                    ]);
                }

                if ($request->input('discount')) {
                    if ($card = Card::where('control_no', $request->input('control_no'))) {
                        if (date_diff($dt->toDateTime(), Carbon::parse($card->first()->date_expired)->toDateTime())->days > 0) {
                            if ($card->first()->status) {
                                switch ($request->input('plan')) {
                                    case 'HP':
                                        $transaction = Transaction::create([
                                            'user_id'   =>  auth()->user()->id,
                                            'pager_no'  =>  Transaction::whereDate('created_at', $dt->toDateString())->count() == 0 ? 1 : Transaction::whereDate('created_at', $dt->toDateString())->count() + 1,
                                            'space_id'  =>  $request->input('space_id'),
                                            'pax'       =>  $request->input('pax'),
                                            'duration'  =>  $request->input('duration'),
                                            'start'     =>  $dt->toDateTimeString(),
                                            'end'       =>  $dt->addHours($request->input('duration')),
                                            'sub_total' =>  Space::where('id', $request->input('space_id'))->first()->rate * $request->input('duration'),
                                            'discount'  =>  $card->first()->discount,
                                            'total'     =>  0,
                                            'status'    =>  'CLOCKED IN',
                                            'type'      =>  'REGULAR'
                                        ]);

                                        event(new NewTransactionAdded($transaction->format()));
                                        break;

                                    case 'DP':
                                        Transaction::create([
                                            'user_id'   =>  auth()->user()->id,
                                            'pager_no'  =>  'N/A',
                                            'space_id'  =>  $request->input('space_id'),
                                            'pax'       =>  $request->input('pax'),
                                            'duration'  =>  $request->input('duration'),
                                            'start'     =>  $dt->toDateTimeString(),
                                            'end'       =>  '',
                                            'sub_total' =>  Space::where('id', $request->input('space_id'))->first()->daily_rate,
                                            'discount'  =>  $card->first()->discount,
                                            'total'     =>  0,
                                            'status'    =>  'CLOCKED IN',
                                            'type'      =>  'REGULAR'
                                        ]);
                                        break;
                                }

                                return response()->json([
                                    'message'   =>  'Transaction Added!'
                                ]);
                            } else {
                                return response()->json([
                                    'message'   =>  'Card Not Activated'
                                ], 401);
                            }
                        } else {
                            return response()->json([
                                'message'   =>  $card->first()->name . ' is already expired.'
                            ], 401);
                        }
                    } else {
                        return response()->json([
                            'message'   =>  $request->input('control_no') . ' is an invalid card.'
                        ], 401);
                    }
                } else {
                    switch ($request->input('plan')) {
                        case 'HP':
                            $transaction = Transaction::create([
                                'user_id'   =>  auth()->user()->id,
                                'space_id'  =>  $request->input('space_id'),
                                'pager_no'  =>  Transaction::whereDate('created_at', $dt->toDateString())->count() == 0 ? 1 : Transaction::whereDate('created_at', $dt->toDateString())->count() + 1,
                                'pax'       =>  $request->input('pax'),
                                'duration'  =>  $request->input('duration'),
                                'start'     =>  $dt->toDateTimeString(),
                                'end'       =>  $dt->addHours($request->input('duration')),
                                'sub_total' =>  Space::where('id', $request->input('space_id'))->first()->rate * $request->input('duration'),
                                'discount'  =>  0,
                                'total'     =>  0,
                                'status'    =>  'CLOCKED IN',
                                'type'      =>  'REGULAR'
                            ]);

                            event(new NewTransactionAdded($transaction->format()));
                            break;

                        case 'DP':
                            $transaction = Transaction::create([
                                'user_id'   =>  auth()->user()->id,
                                'space_id'  =>  $request->input('space_id'),
                                'pager_no'  =>  '',
                                'pax'       =>  $request->input('pax'),
                                'duration'  =>  $request->input('duration'),
                                'start'     =>  $dt->toDateTimeString(),
                                'end'       =>  '',
                                'sub_total' =>  Space::where('id', $request->input('space_id'))->first()->daily_rate,
                                'discount'  =>  0,
                                'total'     =>  0,
                                'status'    =>  'CLOCKED IN',
                                'type'      =>  'REGULAR'
                            ]);
                            
                            event(new NewTransactionAdded($transaction->format()));
                            break;
                    }

                    return response()->json([
                        'message'   =>  'Transaction Added!'
                    ]);
                }
                break;

            case 'subscription':
                $request->validate([
                    'subscription_code'     =>  'required'
                ]);

                if ($subscription = Subscription::where('subscription_code', $request->input('subscription_code'))->first()) {
                    if ($subscription->user_id == $request->user()->id) {
                        $now = $dt->toDateTime();
                        $expiry = Carbon::parse($subscription->date_expired)->toDateTime();
                        $diff = $now->diff($expiry);

                        if ($diff->format('%r%a') > 0) {
                            $transaction = Transaction::create([
                                'user_id'   =>  auth()->user()->id,
                                'space_id'  =>  $subscription->space_id,
                                'pager_no'  =>  '',
                                'pax'       =>  0,
                                'duration'  =>  24,
                                'start'     =>  $dt->toDateTimeString(),
                                'end'       =>  '',
                                'sub_total' =>  Space::where('id', $subscription->space_id)->first()->daily_rate,
                                'discount'  =>  100,
                                'total'     =>  0,
                                'status'    =>  'CLOCKED IN',
                                'type'      =>  'SUBSCRIPTION'
                            ]);

                            event(new NewTransactionAdded($transaction->format()));
                        } else {
                            return response()->json([
                                'message'   =>  'Your subscription is already expired.'
                            ], 401);
                        }
                    } else {
                        return response()->json([
                            'message'   =>  'This subscription code is not yours.'
                        ], 401);
                    }
                } else {
                    return response()->json([
                        'message'   =>  'You Don\'t have Any Active Subscription'
                    ], 401);
                }
                break;
        }
    }
}
