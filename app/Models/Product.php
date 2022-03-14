<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    const PAGINATION_ITEMS_PER_PAGE = 10;

    protected $table = 'product';

}
