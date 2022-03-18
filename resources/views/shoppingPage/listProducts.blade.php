@extends('layout')

@section('content')
    <style>
        .list-group-item button a, .list-group-item button a:hover, .list-group-item button a:visited {
            color: white;
        }
    </style>
    <ul class="list-group">
        @foreach($items as $product)
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-3">
                        <img src="{{ $product['image_url'] }}" height="150" alt=""><br>
                        <div class="text-center">
                            $ {{ $product['price'] }}
                        </div>
                    </div>
                    <div class="col-md-7">
                        <a href="/shop/{{ $product['id']  }}"> {{ $product['title'] }} </a>
                    </div>
                    <div class="col-md-2">
                            @auth
                                <select name="quantity-item-{{ $product['id'] }}" id="quantity-item-{{ $product['id'] }}">
                                    @for($i = 1; $i<=10; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                                <button type="button" class="btn btn-primary btn-add_to_cart" data-product_id="{{ $product['id']  }}">
                                    Add to cart
                                </button>
                            @else
                            <button type="button" class="btn btn-primary">
                                <a href="{{ route('login') }}" class="">Log in</a>
                            </button><br><br>
                                @if (Route::has('register'))
                                    <button type="button" class="btn btn-primary">
                                        <a href="{{ route('register') }}" class="">Register</a>
                                    </button>
                                @endif
                            @endauth
                    </div>
                </div>
            </li>
        @endforeach
    </ul>

    @include('partials.simplePagination')

    //  To show any eventuality
    <div class="modal" tabindex="-1" id="myErrorsModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">There has been an error</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        var Shop = {
            modal: $('#myErrorsModal'),
            setButtonListeners: function() {
                $('.list-group').on('click', '.btn-add_to_cart', function () {
                    productId = $(this).data('product_id');
                    quantity = $(this).parent().find('select').val();
                    var addToCartPromise = Shop.updateCart(productId, quantity);
                    addToCartPromise
                        .done(function (data) {
                            Shop.updateAddToCartButton(data);
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
            updateCart: function(productId, quantity) {
                return $.post('/api/cart/updateItem', {
                    productId: productId,
                    quantity: quantity,
                });
            },
        };

        $().ready(function() {
            Shop.setButtonListeners();
        });
    </script>
@endsection
