<?php

namespace App\Services;

use App\Models\Product;

class ProductRepository
{

    /**
     * It returns all the products in the `products` table, within the corresponding offset related to a given page
     * (the page parameter is automagically solved by laravel, it should be a `page=X` GET parameter)
     * @return mixed
     */
    public function getPaginatedList()
    {
        return Product::query()
            ->simplePaginate(Product::PAGINATION_ITEMS_PER_PAGE)
            ->toArray();
    }

    /**
     * @param $productId
     * @return Product|null
     */
    public final function getProduct($productId)
    {
        return Product::find($productId) ?? null;
    }
}
