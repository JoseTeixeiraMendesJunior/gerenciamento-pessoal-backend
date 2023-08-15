<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Models\TransactionCategory;
use App\Http\Resources\TransactionCategoryResource;
use App\Http\Requests\TransactionCategoryRequest;

class TransactionCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $transaction_categorys = auth()->user()->transactionCategories;

            return TransactionCategoryResource::collection($transaction_categorys);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error retrieving  transactions categories.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TransactionCategoryRequest $request)
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
            $transaction_category = auth()->user()->transactionCategories()->create($data);

            return TransactionCategoryResource::make($transaction_category);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error creating  transaction category.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TransactionCategory $transaction_category)
    {
        try {

            return TransactionCategoryResource::make($transaction_category);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error retrieving transaction category.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransactionCategory $transaction_category)
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

            $transaction_category->update($data);

            return response()->json([
                'message' => 'Recurring transaction updated successfully.',
                'Transaction' => $transaction_category,
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error updating  transaction category.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransactionCategory $transaction_category)
    {
        try {

            $transaction_category->delete();

            return response()->json([
                'message' => 'Recurring transaction deleted successfully.',
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error deleting  transaction category.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
