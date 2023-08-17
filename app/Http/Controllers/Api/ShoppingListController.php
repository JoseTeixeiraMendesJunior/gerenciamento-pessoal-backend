<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShoppingListRequest;
use App\Http\Resources\ShoppingListResource;
use App\Models\ShoppingList;
use Illuminate\Http\Request;

class ShoppingListController extends Controller
{
    public function index(Request $request)
    {
		try {
            $shoppingLists = $request->user()->shoppingList;

            return ShoppingListResource::collection($shoppingLists);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function store(ShoppingListRequest $request)
    {
        try {

            $data = [
				"name"=>$request->name,
				"items"=>json_encode($request->items),
			];
            $shoppingList = auth()->user()->shoppingList()->create($data);

            return response()->json([
                'shoppingList' => $shoppingList,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function show(Request $request, ShoppingList $shoppingList)
	{
		try {
            return response()->json([
                'shoppingList' => $shoppingList,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
	}

    public function update(Request $request, ShoppingList $shoppingList)
    {
        try {
            $shoppingList->update($request->all());

            return response()->json([
                'shoppingList' => $shoppingList,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function destroy(Request $request, ShoppingList $shoppingList)
    {
        try {
            $shoppingList->delete();

            return response()->json([
                'shoppingList' => $shoppingList,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
