@extends('layouts.app')
@section('content')
    <div class="mt-0">
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="false">
            <div class="carousel-inner">
                @foreach ($sliders as $key => $sliderItem)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        @if ($sliderItem->image)
                            <img src="{{ asset($sliderItem->image) }}" class="d-block w-100" alt="image">
                        @endif
                        <div class="carousel-caption d-none d-md-block">
                            <div class="custom-carousel-content">
                                <h5>{{ $sliderItem->title }}</h5>
                                <p>{{ $sliderItem->description }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <div class="py-5 bg-white">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 text-center">
                        <h4>Welcome to Laravel of web IT E-Commerces</h4>
                        <div class="underline mx-auto">
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam inventore cupiditate laudantium sunt
                            mollitia omnis dolorum enim numquam, recusandae eligendi! Deserunt soluta modi nulla nostrum
                            dicta,
                            labore eaque! Aliquam repudiandae consequatur laboriosam labore soluta quas voluptatum mollitia
                            expedita dicta? Voluptatibus eum perferendis magni ipsa vel ducimus alias, cumque officia sequi
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-5">
            <div class="container">
                <div class="row ">
                    <div class="col-md-12">
                        <h4>Tranding Products</h4>
                        <div class="underline mb-4"></div>
                    </div>
                    @if ($trandingProduct)
                        <div class="col-md-12">
                            <div class="owl-carousel owl-theme tranding-product">
                                @foreach ($trandingProduct as $product)
                                    <div class="item">
                                        <div class="product-card">
                                            <div class="product-card-img">
                                                <label class="stock bg-success">New</label>
                                                @if ($product->productImages->count() > 0)
                                                    <a
                                                        href="{{ url('/collections/' . $product->category->slug . '/' . $product->slug) }}">
                                                        <img src="{{ asset($product->productImages[0]->image) }}"
                                                            class="w-100" alt=" {{ $product->name }}">
                                                    </a>
                                                @endif
                                            </div>
                                            <div class="product-card-body">
                                                <p class="product-brand"> {{ $product->brand }}</p>
                                                <h5 class="product-name">
                                                    <a
                                                        href="{{ url('/collections/' . $product->category->slug . '/' . $product->slug) }}">
                                                        {{ $product->name }}
                                                    </a>
                                                </h5>
                                                <div>
                                                    <span
                                                        class="selling-price"><span>&#8377;</span>{{ $product->selling_price }}</span>
                                                    <span
                                                        class="original-price"><span>&#8377;</span>{{ $product->original_price }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="col-md-12">
                            <div class="p-2">
                                <h4>No Products Avialable {{ $categorys->name }}</h4>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('.tranding-product').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 5
                }
            }
        })
    </script>
@endsection
