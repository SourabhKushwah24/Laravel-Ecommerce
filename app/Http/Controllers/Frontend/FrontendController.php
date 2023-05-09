<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('status', '0')->get();
        $trandingProduct = Product::where('trending', '1')->latest()->take(12)->get();
        return view('frontend.index', compact('sliders', 'trandingProduct'));
    }

    public function newArrivals()
    {
        $newArrivalProducts = Product::latest()->take(16)->get();
        return view('frontend.pages.new-arrival', compact('newArrivalProducts'));
    }

    public function featuredProduct()
    {
        $featuredProduct = Product::where('featured', '1')->latest()->get();
        return view('frontend.pages.featured', compact('featuredProduct'));
    }

    public function categories()
    {
        $categorys = Category::where('status', '0')->get();
        return view('frontend.collections.categories.index', compact('categorys'));
    }
    public function product($category_slug)
    {
        $categorys = Category::where('slug', $category_slug)->first();
        if ($categorys) {
            $products = $categorys->product()->get();
            return view('frontend.collections.products.index', compact('categorys'));
        } else {
            return redirect()->back();
        }
    }
    public function productView(string $category_slug, string $product_slug)
    {
        $categorys = Category::where('slug', $category_slug)->first();
        if ($categorys) {
            $products = $categorys->product()->where('slug', $product_slug)->where('status', '0')->first();
            if ($products) {
                return view('frontend.collections.products.view', compact('products', 'categorys'));
            } else {
                return redirect()->back();
            }
        } else {
            return redirect()->back();
        }
    }
    public function thankyou()
    {
        return view('frontend.thank-you');
    }
}
