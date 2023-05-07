<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Http\Requests\CategoryFormRequest;
use App\Models\Category;

class CategortController extends Controller
{
    public function index()
    {
        return view('admin.category.index');
    }
    public function create()
    {
        return view('admin.category.create');
    }
    public function store(CategoryFormRequest $request)
    {
        $validatedata = $request->validated();

        $category = new Category();
        $category->name = $validatedata['name'];
        $category->slug = Str::slug($validatedata['slug']);
        $category->description = $validatedata['description'];

        $uploadfile = 'uploads/category/';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename  = time() . '.' . $ext;
            $file->move('uploads/category/', $filename);
            $category->image = $uploadfile . $filename;
        }

        $category->meta_title = $validatedata['meta_title'];
        $category->meta_keyword = $validatedata['meta_keyword'];
        $category->meta_description = $validatedata['meta_description'];
        $category->status = $request->status == true ? '1' : '0';
        $category->save();
        return redirect('admin/category')->with('message', 'Category Added Successfully');
    }

    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }
    public function update(CategoryFormRequest $request, $category)
    {
        $validatedata = $request->validated();

        $category = Category::findOrFail($category);

        $category->name = $validatedata['name'];
        $category->slug = Str::slug($validatedata['slug']);
        $category->description = $validatedata['description'];

        $uploadfile = 'uploads/category/';
        if ($request->hasFile('image')) {
            $path = 'uploads/category' . $category->image;
            if (File::exists($path)) {
                File::delete();
            }
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename  = time() . '.' . $ext;
            $file->move('uploads/category', $filename);
            $category->image = $uploadfile . $filename;
        }

        $category->meta_title = $validatedata['meta_title'];
        $category->meta_keyword = $validatedata['meta_keyword'];
        $category->meta_description = $validatedata['meta_description'];
        $category->status = $request->status == true ? '1' : '0';
        $category->save();
        return redirect('admin/category')->with('message', 'Category Updated Successfully');
    }
}
