<?php

namespace App\Http\Livewire\Frontend\Product;

use App\Models\Cart;
use Livewire\Component;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class View extends Component
{
    public $categorys, $products, $ProductColorSelector, $quantityCount = 1, $productColorId;

    public function mount($categorys, $products)
    {
        $this->categorys = $categorys;
        $this->products = $products;
    }
    public function incrementQuantity()
    {
        if ($this->quantityCount >= 1) {

            $this->quantityCount++;
        }
    }
    public function decrementQuantity()
    {
        if ($this->quantityCount > 1) {
            $this->quantityCount--;
        }
    }

    public function addToCart(int $productId)
    {
        // Check User Login or Not
        if (Auth::check()) {
            //Check Product Availble or not
            if ($this->products->where('id', $productId)->where('status', '0')->exists()) {
                //Check Product Color Avaiable or Not
                if ($this->products->productColor()->count() > 1) {
                    // dd("ok");
                    if ($this->ProductColorSelector != NUll) {
                        // dd("Color Selected");
                        // For this Condition are Check Product add with color already added or not
                        if (Cart::where('user_id', auth()->user()->id)->where('product_id', $productId)->where('product_color_id', $this->productColorId)->exists()) {
                            $this->dispatchBrowserEvent(
                                'message',
                                [
                                    'text' => 'Product Already Added',
                                    'type' => 'warning',
                                    'status' => 200
                                ]
                            );
                        } else {

                            $productColor =  $this->products->productColor()->where("id", $this->productColorId)->first();
                            // Check Color Quantity Avaible or not
                            if ($productColor->quantity > 1) {
                                if ($productColor->quantity > $this->quantityCount) {
                                    //Insert Product Cart
                                    Cart::create([
                                        'user_id' => auth()->user()->id,
                                        'product_id' => $productId,
                                        'product_color_id' => $this->productColorId,
                                        'quantity' => $this->quantityCount
                                    ]);
                                    $this->emit("CartAddeddUpdate");
                                    $this->dispatchBrowserEvent(
                                        'message',
                                        [
                                            'text' => 'Product Add To Cart SuccessFully',
                                            'type' => 'success',
                                            'status' => 200
                                        ]
                                    );
                                } else {
                                    $this->dispatchBrowserEvent(
                                        'message',
                                        [
                                            'text' => 'Only ' . $productColor->quantity . ' Quantity Avaiable',
                                            'type' => 'warning',
                                            'status' => 404
                                        ]
                                    );
                                }
                            } else {
                                $this->dispatchBrowserEvent(
                                    'message',
                                    [
                                        'text' => 'Out of Stock',
                                        'type' => 'waring',
                                        'status' => 404
                                    ]
                                );
                            }
                        }
                    } else {
                        $this->dispatchBrowserEvent(
                            'message',
                            [
                                'text' => 'Please Select Your Product Color',
                                'type' => 'info',
                                'status' => 404
                            ]
                        );
                    }
                } else {
                    // For this Condition are Check Product already added or not
                    if (Cart::where('user_id', auth()->user()->id)->where('product_id', $productId)->exists()) {
                        $this->dispatchBrowserEvent(
                            'message',
                            [
                                'text' => 'Product Already Added',
                                'type' => 'warning',
                                'status' => 200
                            ]
                        );
                    } else {
                        //check Product Quantity Avaiable or not
                        if ($this->products->quantity > 0) {
                            //check Product quantityCount Avaiable or not
                            if ($this->products->quantity > $this->quantityCount) {
                                Cart::create([
                                    'user_id' => auth()->user()->id,
                                    'product_id' => $productId,
                                    'quantity' => $this->quantityCount
                                ]);
                                $this->emit("CartAddeddUpdate");
                                $this->dispatchBrowserEvent(
                                    'message',
                                    [
                                        'text' => 'Product Add To Cart SuccessFully',
                                        'type' => 'success',
                                        'status' => 200
                                    ]
                                );
                            } else {
                                $this->dispatchBrowserEvent(
                                    'message',
                                    [
                                        'text' => 'Only ' . $this->products->quantity . ' Quantity Avaiable',
                                        'type' => 'warning',
                                        'status' => 404
                                    ]
                                );
                            }
                        } else {
                            $this->dispatchBrowserEvent(
                                'message',
                                [
                                    'text' => 'Out Of Stock',
                                    'type' => 'warning',
                                    'status' => 404
                                ]
                            );
                        }
                    }
                }
            } else {
                $this->dispatchBrowserEvent(
                    'message',
                    [
                        'text' => 'Product Does Not Exists',
                        'type' => 'warning',
                        'status' => 404
                    ]
                );
            }
        } else {
            $this->dispatchBrowserEvent(
                'message',
                [
                    'text' => 'Please Login To Continue',
                    'type' => 'info',
                    'status' => 401
                ]
            );
        }
    }



    public function colorSelected($productColorId)
    {
        $this->productColorId = $productColorId;
        $productColor = $this->products->productColor()->where('id', $productColorId)->first();
        $this->ProductColorSelector = $productColor->quantity;
        if ($this->ProductColorSelector == 0) {
            $this->ProductColorSelector = 'outofstock';
        }
    }
    public function addToWishlist($product_id)
    {
        if (Auth::check()) {
            if (Wishlist::where('user_id', auth()->user()->id)->where('product_id', $product_id)->exists()) {
                // session()->flash('message', 'Already Added');
                $this->dispatchBrowserEvent(
                    'message',
                    [
                        'text' => 'Already Added',
                        'type' => 'warning',
                        'status' => 409
                    ]
                );
                return false;
            } else {
                Wishlist::create([
                    'user_id' => auth()->user()->id,
                    'product_id' => $product_id,
                    // session()->flash('message', 'Product Addedd SuccessFully'),
                    $this->emit('wishlistAddedUpdate'),
                    $this->dispatchBrowserEvent(
                        'message',
                        [
                            'text' => 'Product Addedd SuccessFully',
                            'type' => 'success',
                            'status' => 200
                        ]
                    )
                ]);
            }
        } else {
            // session()->flash('message', 'Please Login To Continue');
            $this->dispatchBrowserEvent(
                'message',
                [
                    'text' => 'Please Login To Continue',
                    'type' => 'info',
                    'status' => 401
                ]
            );
            return false;
        }
    }

    public function render()
    {
        return view('livewire.frontend.product.view', [
            'categorys' => $this->categorys,
            'products' => $this->products,
        ]);
    }
}
