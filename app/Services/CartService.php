<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CartService
{

    public final function listAll(int $userId)
    {
        $userCartContent = DB::table('cart')
            ->join('product' , 'cart.product_id', '=', 'product.id')
            ->select('cart.*', 'product.title', 'product.price', 'product.image_url')
            ->where('user_id', $userId)
            ->get();

        return $userCartContent;
    }

    public final function changeProductQuantity(int $userId, int $productId, int $quantity)
    {
        Cart::updateOrCreate(
            [
                'user_id' => $userId,
                'product_id' => $productId
            ],
            ['quantity' => $quantity],
        );
    }

    public final function clearCart(int $userId)
    {
        Cart::where('user_id', $userId)->delete();
    }

    public final function removeProduct(int $userId, $productId)
    {
        Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->delete();
    }

    public final function checkout(int $userId)
    {
        $products = $this->listAll($userId);
        //  TODO: construct the email
        $this->clearCart($userId);
    }
}
