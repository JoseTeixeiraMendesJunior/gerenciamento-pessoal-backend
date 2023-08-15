<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecurringTransactionRequest;
use App\Http\Resources\RecurringTransactionResource;
use App\Models\RecurringTransaction;
use Illuminate\Http\Request;
use Exception;

class RecurringTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $recurringTransactions = auth()->user()->recurringTransactions;

            return RecurringTransactionResource::collection($recurringTransactions);

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
    public function store(RecurringTransactionRequest $request)
    {
        try {

            $data = $request->only([
                'description',
                'amount',
                'type',
                'date',
                'frequency',
                'active',
                'transaction_category_id',
            ]);
            $recurringTransaction = auth()->user()->recurringTransactions()->create($data);

            return RecurringTransactionResource::make($recurringTransaction);

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
    public function show(RecurringTransaction $recurringTransaction)
    {
        try {

            return RecurringTransactionResource::make($recurringTransaction);

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
    public function update(Request $request, RecurringTransaction $recurringTransaction)
    {
        try {

            $data = $request->only([
                'description',
                'amount',
                'type',
                'date',
                'frequency',
                'active',
                'transaction_category_id',
            ]);

            $recurringTransaction->update($data);

            return response()->json([
                'message' => 'Recurring transaction updated successfully.',
                'recurringTransaction' => $recurringTransaction,
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
    public function destroy(RecurringTransaction $recurringTransaction)
    {
        try {

            $recurringTransaction->delete();

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
