<?php

namespace App\Http\Livewire\Frontend\Product;

use App\Models\Product;
use Livewire\Component;

class Index extends Component
{
    public $products, $categorys, $brandInputs = [], $priceInputs;
    protected $queryString = [
        'brandInputs' => ['except' => '', 'as' => 'brand'],
        'priceInputs' => ['except' => '', 'as' => 'price'],
    ];

    public function mount($categorys)
    {
        $this->categorys = $categorys;
    }
    public function render()
    {
        $this->products = Product::where('category_id', $this->categorys->id)
            ->when($this->brandInputs, function ($q) {
                $q->whereIn('brand', $this->brandInputs);
            })
            ->when($this->priceInputs, function ($q) {
                $q->when($this->priceInputs == 'high-to-low', function ($q2) {
                    $q2->orderBy('selling_price', "DESC");
                })->when($this->priceInputs == 'low-to-high', function ($q2) {
                    $q2->orderBy('selling_price', "ASC");
                });
            })
            ->where('status', '0')
            ->get();

        return view('livewire.frontend.product.index', ['products' => $this->products, 'categorys' => $this->categorys]);
    }
}
