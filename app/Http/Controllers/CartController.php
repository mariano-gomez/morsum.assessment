<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController
{

    /**
     * Returns all the elements, related to the current user's cart,
     */
    public function showCartContent(CartService $cartService, Request $request)
    {
        //  First, we check if the user exists and is valid
        $user = Auth::user();
        if (is_null($user)) {
            return response()->json(
                ['message' => 'Invalid user']
            , 400);
        }
        $cartContent = $cartService->listAll($user->id);
        return response()->json(
            ['message' => $cartContent]
        , 200);
    }

    /**
     * It adds a product to the logged user's cart
     */
    public function updateItem(CartService $cartService, Request $request)
    {
        //  First, we check if the user exists and is valid
        $user = Auth::user();
        if (is_null($user)) {
            return response()->json(
                ['message' => 'Invalid user']
            , 400);
        }

        //  Then, we check that all the required inputs are coming, and with valid values
        $productId = $request->input('productId');
        $quantity = $request->input('quantity');
        $validator = Validator::make($request->all(), [
            'productId' => 'required|numeric|min:1',
            'quantity' => 'required|numeric|min:0|max:10',
        ]);

        if ($validator->fails()) {
            return response()->json(
                ['message' => $validator->errors()->first()]
            , 400);
        }

        //  If everything works ok, then we add the elements to the cart
        $cartService->changeProductQuantity($user->id, $productId, $quantity);
        return response()->json(
            ['message' => 'success']
        , 200);
    }

    /**
     * Removes all items on the logged user's cart
     */
    public function cleanCart(CartService $cartService, Request $request)
    {
        //  First, we check if the user exists and is valid
        $user = Auth::user();
        if (is_null($user)) {
            return response()->json(json_encode(
                ['message' => 'Invalid user']
            ), 400);
        }

        //  If everything works ok, then we add the elements to the cart
        $cartService->clearCart($user->id);
        return response()->json(json_encode(
            ['message' => 'success']
        ), 200);
    }

    /**
     * Removes all items on the logged user's cart
     */
    public function removeProduct(CartService $cartService, int $id)
    {
        //  First, we check if the user exists and is valid
        $user = Auth::user();
        if (is_null($user)) {
            return response()->json(json_encode(
                ['message' => 'Invalid user']
            ), 400);
        }

        //  Then, we check that all the required inputs are coming, and with valid values
        $productId = $id;
        $validator = Validator::make(['productId' => $productId], [
            'productId' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(
                ['message' => $validator->errors()->first()]
                , 400);
        }

        //  If everything works ok, then we add the elements to the cart
        $cartService->removeProduct($user->id, $productId);
        return response()->json(json_encode(
            ['message' => 'success']
        ), 200);
    }
}
