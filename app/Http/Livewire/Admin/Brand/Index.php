<?php

namespace App\Http\Livewire\Admin\Brand;

use App\Models\Brand;
use App\Models\Category;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $name, $slug, $status, $brand_id, $category_id;

    public function rules()
    {
        return [
            'name' => 'required|string',
            'slug' => 'required|string',
            'category_id' => 'required|integer',
            'status' => 'nullable',
        ];
    }
    public function resetInput()
    {
        $this->name = Null;
        $this->slug = Null;
        $this->status = Null;
        $this->brand_id = Null;
        $this->category_id = Null;
    }

    public function saveBrand()
    {
        $validatedData = $this->validate();
        Brand::create([
            'name' => $this->name,
            'slug' => Str::slug($this->slug),
            'status' => $this->status == true ? '1' : '0',
            'category_id' => $this->category_id,
        ]);
        session()->flash('message', 'Brand Added SuccessFully');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function editBrand(int $brand_id)
    {
        $this->brand_id = $brand_id;
        $brand = Brand::findOrFail($brand_id);
        $this->name =  $brand->name;
        $this->slug =  $brand->slug;
        $this->status =  $brand->status;
        $this->category_id =  $brand->category_id;
    }
    public function updateBrand()
    {
        $validatedData = $this->validate();
        Brand::findOrFail($this->brand_id)->update([
            'name' => $this->name,
            'slug' => Str::slug($this->slug),
            'status' => $this->status == true ? '1' : '0',
            'category_id' => $this->category_id,

        ]);
        session()->flash('message', 'Brand Updated SuccessFully');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }
    public function deletebrand($brand_id)
    {
        $this->brand_id = $brand_id;
    }
    public function destroyBrand()
    {
        $brand = Brand::find($this->brand_id)->delete();
        session()->flash('message', "Brand Deleted SuccessFully");
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function render()
    {
        $categorys = Category::where('status', '0')->get();
        $brand  = Brand::orderBy('id', 'DESC')->paginate(10);
        return view('livewire.admin.brand.index', ['brands' => $brand, 'categorys' => $categorys])
            ->extends('layouts.admin')
            ->section('content');
    }
}
