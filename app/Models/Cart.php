<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{

    protected $fillable = ['user_id', 'product_id', 'quantity'];
    protected $table = 'cart';

    //  To make a distinction with the `$table` variable

}
