@extends('layouts.app')

@section('title')
    {{ $categorys->meta_title }}
@endsection
@section('meta_keyword')
    {{ $categorys->meta_keyword }}
@endsection
@section('meta_description')
    {{ $categorys->meta_description }}
@endsection
@section('content')
    <div class="py-3 py-md-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="mb-4">Our Products</h4>
                </div>
                {{-- @include('livewire.frontend.product.index') --}}
                <livewire:frontend.product.index :categorys="$categorys" />
            </div>
        </div>
    </div>
@endsection
