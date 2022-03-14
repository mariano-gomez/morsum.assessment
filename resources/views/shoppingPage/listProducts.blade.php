@extends('layout')

@section('content')
    <ul>
        @foreach($items as $product)
            <li>
                <img src="{{ $product['image_url'] }}" height="150" alt="">
                <a href="/shop/{{ $product['id']  }}"> {{ $product['title'] }} </a>
            </li>
        @endforeach
    </ul>
    @include('partials.simplePagination')
@endsection
