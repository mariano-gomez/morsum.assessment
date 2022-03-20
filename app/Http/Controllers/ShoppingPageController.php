<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\ProductRepository;
use Illuminate\Support\Facades\Auth;

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
    public final function shopCheckout(CartService $cartService)
    {
        //  First, we check if the user exists and is valid
        $user = Auth::user();
        if (is_null($user)) {
            return redirect('/shop');
        }

        $cartProducts = $cartService->listAll($user->id);

        return view('shoppingPage.shopCheckout', [
            'user'      => $user,
            'items'     => $cartProducts
        ]);
    }
}
