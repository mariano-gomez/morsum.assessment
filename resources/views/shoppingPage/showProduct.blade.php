@extends('layout')

@section('content')
    <img src="{{ $product->image_url }}" height="150" alt="">
    {{ $product->title }}
@endsection
