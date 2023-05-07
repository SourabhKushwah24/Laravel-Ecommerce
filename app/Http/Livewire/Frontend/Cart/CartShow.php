<?php

namespace App\Http\Livewire\Frontend\Cart;

use App\Models\Cart;
use Livewire\Component;

class CartShow extends Component
{
    public $cart, $totalprice = 0;

    public function decrementQuantity(int $cart_id)
    {
        $cardData = Cart::where('user_id', auth()->user()->id)->where('id', $cart_id)->first();
        if ($cardData) {
            // This condition are check color quantity
            if ($cardData->productColor()->where('id', $cardData->product_color_id)->exists()) {
                $productColor = $cardData->productColor()->where('id', $cardData->product_color_id)->first();
                if ($productColor->quantity >= $cardData->quantity && $cardData->quantity > 1) {

                    $cardData->decrement('quantity');
                    $this->dispatchBrowserEvent(
                        'message',
                        [
                            'text' => 'Quantity Updated',
                            'type' => 'success',
                            'status' => 200
                        ]
                    );
                } else {
                    $this->dispatchBrowserEvent(
                        'message',
                        [
                            'text' => 'Something Went Wrong',
                            'type' => 'error',
                            'status' => 500
                        ]
                    );
                }
            } else {
                // This condition are check non color quantity
                if ($cardData->product->quantity >= $cardData->quantity && $cardData->quantity > 1) {
                    $cardData->decrement('quantity');
                    $this->dispatchBrowserEvent(
                        'message',
                        [
                            'text' => 'Quantity Updated',
                            'type' => 'success',
                            'status' => 200
                        ]
                    );
                } else {
                    $this->dispatchBrowserEvent(
                        'message',
                        [
                            'text' => 'Something Went Wrong',
                            'type' => 'error',
                            'status' => 404
                        ]
                    );
                }
            }
        } else {
            $this->dispatchBrowserEvent(
                'message',
                [
                    'text' => 'Something Went Wrong',
                    'type' => 'error',
                    'status' => 404
                ]
            );
        }
    }
    public function incrementQuantity(int $cart_id)
    {
        $cardData = Cart::where('user_id', auth()->user()->id)->where('id', $cart_id)->first();
        if ($cardData) {
            // This condition are check color quantity
            if ($cardData->productColor()->where('id', $cardData->product_color_id)->exists()) {
                $productColor = $cardData->productColor()->where('id', $cardData->product_color_id)->first();
                if ($productColor->quantity > $cardData->quantity) {

                    $cardData->increment('quantity');
                    $this->dispatchBrowserEvent(
                        'message',
                        [
                            'text' => 'Quantity Updated',
                            'type' => 'success',
                            'status' => 200
                        ]
                    );
                } else {
                    $this->dispatchBrowserEvent(
                        'message',
                        [
                            'text' => 'Only ' . $productColor->quantity . ' Quantity Available',
                            'type' => 'error',
                            'status' => 404
                        ]
                    );
                }
            } else {
                // This condition are check non color quantity
                if ($cardData->product->quantity > $cardData->quantity) {
                    $cardData->increment('quantity');
                    $this->dispatchBrowserEvent(
                        'message',
                        [
                            'text' => 'Quantity Updated',
                            'type' => 'success',
                            'status' => 200
                        ]
                    );
                } else {
                    $this->dispatchBrowserEvent(
                        'message',
                        [
                            'text' => 'Only ' . $cardData->product->quantity . ' Quantity Available',
                            'type' => 'error',
                            'status' => 404
                        ]
                    );
                }
            }
        } else {
            $this->dispatchBrowserEvent(
                'message',
                [
                    'text' => 'Something Went Wrong',
                    'type' => 'error',
                    'status' => 404
                ]
            );
        }
    }


    public function removeCartItem(int $cartId)
    {
        Cart::where('user_id', auth()->user()->id)->where('id', $cartId)->delete();
        $this->emit('CartAddeddUpdate');
        $this->dispatchBrowserEvent(
            'message',
            [
                'text' => 'Cart Item Remove SuccessFully',
                'type' => 'success',
                'status' => 200
            ]
        );
    }

    public function render()
    {
        $this->cart = Cart::where('user_id', auth()->user()->id)->get();
        return view('livewire.frontend.cart.cart-show', ['cart' => $this->cart]);
    }
}
