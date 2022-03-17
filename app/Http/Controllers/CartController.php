<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;

class CartController
{

    /**
     * Returns all the elements, related to the current user's cart,
     */
    public function showCartContent(CartService $cartService, Request $request)
    {
//        return $cartService->listAll($userId);
        return response()->json('showCartContent', 200);
    }

    /**
     * It adds a product to the logged user's cart
     */
    public function addItem(CartService $cartService, Request $request)
    {
        return response()->json('addItem', 201);
    }

    /**
     * It adds a product to the logged user's cart
     */
    public function updateItem(CartService $cartService, Request $request)
    {
        return response()->json('updateItem', 200);
    }

    /**
     * Removes all items on the logged user's cart
     */
    public function cleanCart(CartService $cartService, Request $request)
    {
        return response()->json('cleanCart', 200);
    }

    /**
     * Emulates the checkout of a purchase, sending an email with all the items in the cart, and then cleaning the cart
     */
    public function doCheckout(CartService $cartService, Request $request)
    {
        return response()->json('doCheckout', 200);
    }
}
