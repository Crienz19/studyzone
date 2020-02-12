<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Space;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function getOverallTransactions()
    {
        return Transaction::orderBy('created_at', 'desc')
            ->with('user')
            ->with('space')
            ->get()
            ->map
            ->format();
    }

    public function getAllTransactions()
    {
        $transactions = Transaction::whereDate('created_at', Carbon::now()->timezone('Asia/Manila')->toDateString())
            ->orderBy('created_at', 'desc')
            ->with('user')
            ->with('space')
            ->get()
            ->map
            ->format();

        return response()->json($transactions);
    }

    public function clockMeOut(Request $request, $id)
    {
        $request->validate([
            'discount' => 'required'
        ]);

        $transaction = Transaction::find($id);

        $transaction->update([
            'discount'  =>  $request->input('discount'),
            'total'     =>  $transaction->sub_total - (($request->input('discount') / 100) * $transaction->sub_total),
            'status'    =>  'CLOCKED OUT'
        ]);

        return [
            'discount'  =>  $transaction->sub_total - (($request->input('discount') / 100) * $transaction->sub_total)
        ];
    }

    public function addTime(Request $request, $id)
    {
        $request->validate([
            'hours'     =>  'required'
        ]);

        $transaction = Transaction::find($id);

        $transaction->update([
            'end'       =>  Carbon::parse($transaction->end)->addHours($request->input('hours')),
            'duration'  =>  $transaction->duration + $request->input('hours'),
            'sub_total' =>  $transaction->sub_total + (Space::find($transaction->space_id)->rate * $request->input('hours'))
        ]);

        return [
            'message'   =>  'You extend the time with '. $request->input('hours') . ' hrs.'
        ];
    }

    public function deleteTransaction($id)
    {
        Transaction::find($id)->delete();

        return response()->json([
            'message'   =>  'Transaction Deleted!'
        ], 200);
    }
}
