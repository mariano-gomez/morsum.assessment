<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ShoppingPageController
{

    /**
     * It shows the paginated list from the list
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public final function shopList(ProductRepository $productRepository)
    {
        $paginatedResults = $productRepository->getPaginatedList();

        return view('shoppingPage.listProducts', [
            'items'             => $paginatedResults['data'],
            'firstPageUrl'      => $paginatedResults['first_page_url'],
            'previousPageUrl'   => $paginatedResults['prev_page_url'],
            'nextPageUrl'       => $paginatedResults['next_page_url'],
        ]);
    }

    /**
     * It shows the details for a given product
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public final function shopDetail(ProductRepository $productRepository, int $id)
    {
        $product = $productRepository->getProduct($id);

        if (is_null($product)) {
            //  TODO: Go to 'product not found' error page
            echo "product doesn't exists";
        } else {
            return view('shoppingPage.showProduct', [
                'product' => $product
            ]);
        }
    }

    //  TODO: Retrieve items from cart service and pass them to the view
    public final function shopCheckout(CartService $cartService, Request $request)
    {
        //  First, we check if the user exists and is valid
        $user = Auth::user();
        if (is_null($user)) {
            return redirect('/shop');
        }

        $error = null;
        if ($request->session()->has('error')) {
            $error = session('error');
        }

        $cartProducts = $cartService->listAll($user->id);

        return view('shoppingPage.shopCheckout', [
            'user'      => $user,
            'items'     => $cartProducts,
            'error'     => $error
        ]);
    }

    /**
     * Emulates the checkout of a purchase, sending an email with all the items in the cart, and then cleaning the cart
     */
    public function confirmCheckout(CartService $cartService, Request $request)
    {
        //  First, we check if the user exists and is valid
        $user = Auth::user();
        if (is_null($user)) {
            return redirect('/shop');
        }

        $rollback = false;
        DB::beginTransaction();
        try {
            $cartService->checkout($user);
            $cartService->clearCart($user->id);
        } catch (\Exception $e) {
            $request->session()->flash('error', 'The checkout couldn\'t be done. Please try again' );
            //  TODO: See where/how to notify internally about this error)
            $rollback = true;
        }
        $rollback ? DB::rollBack() : DB::commit();

        return redirect('/shop/checkout');
    }
}
