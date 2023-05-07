@extends('layouts.app')

@section('title')
    {{ $products->meta_title }}
@endsection
@section('meta_keyword')
    {{ $products->meta_keyword }}
@endsection
@section('meta_description')
    {{ $products->meta_description }}
@endsection
@section('content')
    <livewire:frontend.product.view :categorys="$categorys" :products="$products" />
@endsection
