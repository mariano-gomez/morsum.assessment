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
                        <img src="{{ $product['image_url'] }}" height="150" alt="">
                    </div>
                    <div class="col-md-7">
                        <a href="/shop/{{ $product['id']  }}"> {{ $product['title'] }} </a>
                    </div>
                    <div class="col-md-2">
                            @auth
                                <button type="button" class="btn btn-primary">
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
@endsection
