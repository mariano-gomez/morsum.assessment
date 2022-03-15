<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductRepository;

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

    //  TODO: Pending
    public final function shopCheckout()
    {

    }
}
