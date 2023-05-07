<div class="py-3 py-md-5">
    <div class="container">
        {{-- @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>set
        @endif --}}
        <div class="row">
            <div class="col-md-5 mt-3">
                <div class="bg-white border" wire:ignore>
                    @if ($products->productImages)
                        {{-- <img src="{{ asset($products->productImages[0]->image) }}" class="w-100" alt="Img"> --}}
                        <div class="exzoom" id="exzoom">
                            <!-- Images -->
                            <div class="exzoom_img_box">
                                <ul class='exzoom_img_ul'>
                                    @foreach ($products->productImages as $itemImage)
                                        <li><img src="{{ asset($itemImage->image) }}" /></li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="exzoom_nav"></div>
                            <!-- Nav Buttons -->
                            <p class="exzoom_btn">
                                <a href="javascript:void(0);" class="exzoom_prev_btn">
                                    < </a>
                                        <a href="javascript:void(0);" class="exzoom_next_btn"> > </a>
                            </p>
                        </div>
                    @else
                        No image Added
                    @endif
                </div>
            </div>
            <div class="col-md-7 mt-3">
                <div class="product-view">
                    <h4 class="product-name">
                        {{ $products->name }}

                    </h4>
                    <hr>
                    <p class="product-path">
                        Home /{{ $products->category->name }}/ {{ $products->name }}
                    </p>
                    <div>
                        <span class="selling-price"><span>&#8377;</span>{{ $products->selling_price }}</span>
                        <span class="original-price"><span>&#8377;</span>{{ $products->selling_price }}</span>
                    </div>
                    <div>
                        @if ($products->productColor->count() > 0)

                            @if ($products->productColor)
                                @foreach ($products->productColor as $colorItem)
                                    <label class="colorSectionLable"
                                        style="background-color:{{ $colorItem->color->code }}"
                                        wire:click="colorSelected({{ $colorItem->id }})">
                                        {{ $colorItem->color->name }}

                                    </label>
                                @endforeach
                                @if ($this->ProductColorSelector == 'outofstock')
                                    <label class="btn-sm py-1 mt-2 text-white bg-danger">Out of Stock</label>
                                @elseif($this->ProductColorSelector > 0)
                                    <label class="btn-sm py-1 mt-2 text-white bg-success">In Stock</label>
                                @endif
                            @endif
                        @else
                            @if ($products->quantity)
                                <label class="btn-sm py-1 mt-2 text-white bg-success">In Stock</label>
                            @else
                                <label class="btn-sm py-1 mt-2 text-white bg-danger">Out of Stock</label>
                            @endif

                        @endif


                    </div>
                    <div class="mt-2">
                        <div class="input-group">
                            <span class="btn btn1" wire:click="decrementQuantity"><i class="fa fa-minus"></i></span>
                            <input type="text" wire:model="quantityCount" value="{{ $this->quantityCount }}"
                                readonly class="input-quantity" />
                            <span class="btn btn1" wire:click="incrementQuantity"><i class="fa fa-plus"></i></span>
                        </div>
                    </div>
                    <div class="mt-2">
                        <button type="button" wire:click="addToCart({{ $products->id }})" class="btn btn1"> <i
                                class="fa fa-shopping-cart"></i> Add To Cart</button>
                        <button type="button" wire:click="addToWishlist({{ $products->id }})" class="btn btn1">
                            <span wire:loading.remove wire:target='addToWishlist'>
                                <i class="fa fa-heart"></i> Add To Wishlist
                            </span>
                            <span wire:loading wire:target='addToWishlist'>Adding...</span>
                        </button>
                    </div>
                    <div class="mt-3">
                        <h5 class="mb-0">Small Description</h5>
                        <p>
                            {!! $products->small_description !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-3">
                <div class="card">
                    <div class="card-header bg-white">
                        <h4>Description</h4>
                    </div>
                    <div class="card-body">
                        <p>
                            {!! $products->description !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(function() {

            $("#exzoom").exzoom({
                "navWidth": 40,
                "navHeight": 40,
                "navItemNum": 5,
                "navItemMargin": 7,
                "navBorder": 1,
                "autoPlay": false,
                "autoPlayTimeout": 2000
            });

        });
    </script>
@endpush
