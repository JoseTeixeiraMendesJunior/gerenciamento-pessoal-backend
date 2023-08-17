<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;
use App\Http\Resources\TransactionResource;
use App\Http\Requests\TransactionRequest;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $transactions = auth()->user()->transactions;

            return TransactionResource::collection($transactions);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error retrieving recurring transactions.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TransactionRequest $request)
    {
        try {

            $data = [
                "description" => $request->description,
                "amount" => $request->amount,
                "type" => $request->type,
                "date" => Carbon::parse($request->date),
                "category" => $request->category,
            ];
            $transaction = auth()->user()->transactions()->create($data);

            return TransactionResource::make($transaction);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error creating recurring transaction.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        try {

            return TransactionResource::make($transaction);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error retrieving recurring transaction.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        try {

            $data = $request->only([
                'description',
                'amount',
                'type',
                'date',
                'category',
            ]);

            $transaction->update($data);

            return response()->json([
                'message' => 'Recurring transaction updated successfully.',
                'recurringTransaction' => $transaction,
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error updating recurring transaction.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        try {

            $transaction->delete();

            return response()->json([
                'message' => 'Recurring transaction deleted successfully.',
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error deleting recurring transaction.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
