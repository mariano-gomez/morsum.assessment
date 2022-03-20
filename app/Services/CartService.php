<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CartService
{

    public final function listAll(int $userId = 1)
    {
        $userCartContent = DB::table('cart')
            ->join('product' , 'cart.product_id', '=', 'product.id')
            ->select('cart.*', 'product.title', 'product.price', 'product.image_url')
            ->where('user_id', $userId)
            ->get();

        return $userCartContent;
    }

    public final function changeProductQuantity(int $userId = 1, int $productId, int $quantity)
    {
        //  TODO: see what kind of response i can return
        Cart::updateOrCreate(
            [
                'user_id' => $userId,
                'product_id' => $productId
            ],
            ['quantity' => $quantity],
        );
    }

    public final function clearCart(int $userId = 1)
    {
        //  TODO: see what kind of response i can return
        Cart::where('user_id', $userId)->delete();
    }

    public final function removeProduct(int $userId = 1, $productId)
    {
        //  TODO: see what kind of response i can return
        Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->delete();
    }

    public final function checkout(int $userId = 1)
    {
        $products = $this->listAll($userId);
        //  TODO: construct the email
        $this->clearCart($userId);
    }
}
