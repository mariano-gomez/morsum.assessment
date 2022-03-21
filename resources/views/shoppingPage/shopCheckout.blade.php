@extends('layout')

@section('content')
    <style>
        .list-group-item button a, .list-group-item button a:hover, .list-group-item button a:visited {
            color: white;
        }
    </style>
    @if (!$items->isEmpty())
        <ul class="list-group">
            @foreach($items as $product)
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-2">
                            <img src="{{ $product->image_url }}" height="150" alt=""><br>
                        </div>
                        <div class="col-md-6">
                            <a href="/shop/{{ $product->id  }}"> {{ $product->title }} </a>
                        </div>
                        <div class="col-md-2 text-center">
                            Units: {{ $product->quantity }} <br>
                            Unit price: $ <span class="unit_price">{{ $product->price }}</span> <br>
                            Sub-total: $ <span class="subtotal">{{ $product->price * $product->quantity }}</span>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger btn-remove_from_cart" data-product_id="{{ $product->product_id  }}">
                                Remove
                            </button>
                        </div>
                    </div>
                </li>
            @endforeach
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-6">
                        <span class="strong">TOTAL: </span> $ <span class="total_price"></span>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-danger btn-clean_cart">
                            Remove everything
                        </button>
                    </div>
                    <div class="col-md-3">
                        <a class="btn btn-primary" href="/shop/confirmCheckout">Confirm purchase</a>
                    </div>
                </div>
            </li>
        </ul>
    @else
        <div>
            <h1>You don't have any products in your cart</h1>
            <a href="/shop">Back to products list</a>
        </div>
    @endif

    <script>
        var Shop = {
            modal: $('#myModal'),
            cleanCart: function() {
                return $.ajax({
                    url: '/api/cart/',
                    method: 'DELETE'
                });
            },
            formatAllPrices: function() {
                $('.subtotal').each(function() {
                    $(this).text($.number($(this).text(), 2, '.', ','));
                });
                $('.unit_price').each(function() {
                    $(this).text($.number($(this).text(), 2, '.', ','));
                });
                Shop.recalculateTotal();
            },
            setButtonListeners: function() {
                $('.list-group').on('click', '.btn-remove_from_cart', function () {
                    let trigger = $(this); //  the button
                    productId = trigger.data('product_id');
                    let removeFromCartPromise = Shop.removeProduct(productId);
                    removeFromCartPromise
                        .done(function (data) {
                            trigger.closest('li').remove();
                            Shop.recalculateTotal();
                        })
                        .fail(function (errorObject) {
                            Shop.showErrorMessage(errorObject);
                        });
                });
                $('.list-group').on('click', '.btn-clean_cart', function () {
                    var cleanCartPromise = Shop.cleanCart();
                    cleanCartPromise
                        .done(function (data) {
                            Shop.showCleanedCartSuccessMessage();
                        })
                        .fail(function (errorObject) {
                            Shop.showErrorMessage(errorObject);
                        });
                });
            },
            showErrorMessage: function (errorObject) {
                jsonResponse = JSON.parse(errorObject.responseJSON);
                Shop.modal
                    .find('.modal-body')
                    .html(
                        'HTTP Code: ' + errorObject.status +
                        '<br>' +
                        'HTTP text: ' + errorObject.statusText +
                        '<br>' +
                        'Response: ' + jsonResponse.message
                    );
                Shop.modal.modal('show');
            },
            showCleanedCartSuccessMessage: function (message) {
                $('ul.list-group li:not(:last)').remove();
                Shop.recalculateTotal();
                Shop.modal
                    .find('.modal-body')
                    .html('Your cart is now empty');
                Shop.modal.modal('show');
            },
            recalculateTotal: function() {
                let sum = 0;
                $('.subtotal').each(function() {
                    sum += Number($(this).text().replace(',', ''));
                    $(this).text($.number($(this).text(), 2, '.', ','));
                });
                $('.total_price').text($.number(sum, 2, '.', ','));
            },
            removeProduct: function(productId) {
                return $.ajax({
                    url: '/api/cart/' + productId,
                    method: 'DELETE'
                });
            },
        };

        $().ready(function() {
            Shop.setButtonListeners();
            Shop.formatAllPrices();
        });
    </script>
@endsection
