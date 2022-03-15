@extends('layout')

@section('content')
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
                        <button type="button" class="btn btn-primary">Add to cart</button>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    @include('partials.simplePagination')
@endsection
