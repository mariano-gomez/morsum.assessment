<?php

namespace App\Services;

use App\Mail\ConfirmCheckout;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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

    public final function checkout(User $user)
    {
        $products = $this->listAll($user->id);
        if ($products->count() == 0) {
            throw new \Exception('Trying to send checkout email for an empty cart');
        }

        Mail::to($user->email)->send(new ConfirmCheckout($products));
    }
}
