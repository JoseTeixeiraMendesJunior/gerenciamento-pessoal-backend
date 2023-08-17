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
                "date" => Carbon::parse($request->date)->format('Y-m-d'),
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

            $data = [
                "description" => $request->description,
                "amount" => $request->amount,
                "type" => $request->type,
                "date" => Carbon::parse($request->date)->format('Y-m-d'),
                "category" => $request->category,
            ];

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

    public function wallet(Request $request)
    {
        try {
            if (!isset($request->month)) {
                $month = Carbon::now()->month;
            } else {
                $month = $request->month;
            }

            if(!isset($request->year)) {
                $year = Carbon::now()->year;
            } else {
                $year = $request->year;
            }

            if ($month < 10) {
                $month = '0' . $month;
            }

            // Calculating the start and end dates of the specified month
            $startDate = Carbon::parse("$year-$month-01")->format('Y-m-d');
            $endDate = Carbon::parse("$year-$month-01")->endOfMonth()->format('Y-m-d');

            // Query to calculate the sum of income and expenses
            $result = Transaction::query()
                ->where('user_id', auth()->user()->id)
                ->whereBetween('date', [$startDate, $endDate])
                ->selectRaw('
                    SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) AS income,
                    SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) AS expense
                ')
                ->get()
                ->toArray();

            return response()->json([
                'income' => round(floatval($result[0]['income']), 2),
                'expense' => round(floatval($result[0]['expense']), 2),
                "total" => round(floatval($result[0]['income']) - floatval($result[0]['expense']) , 2),
            ], 200);


        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error retrieving wallet.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
