@extends('layouts.app')
@section('title', 'Thank You')
@section('content')
    <div class="py-3 pyt-md-4">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="p-4 shadow bg-white">
                        <h2>Your Logo</h2>
                        <h4>Thank You For Shopping With Laravel Ecommerce</h4>
                        <a href="{{ url('collections/') }}" class="btn btn-warning">Shop Now</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
