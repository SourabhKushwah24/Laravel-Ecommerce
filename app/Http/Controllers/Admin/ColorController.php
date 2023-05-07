<?php

namespace App\Http\Controllers\Admin;

use App\Models\Color;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ColorFromRequest;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::orderBy('id', 'DESC')->paginate(5);
        return view('admin.color.index', compact('colors'));
    }
    public function create()
    {
        return view('admin.color.create');
    }
    public function store(ColorFromRequest $request)
    {
        $validateData = $request->validated();
        $validateData['status'] = $request->status == true ? '1' : '0';
        Color::create($validateData);
        return redirect('admin/color')->with('message', "Color Added Successfuly");
    }
    public function edit(Color $color)
    {
        return view('admin.color.edit', compact('color'));
    }
    public function update(ColorFromRequest $request, $color_id)
    {
        $validateData = $request->validated();
        $validateData['status'] = $request->status == true ? '1' : '0';
        Color::find($color_id)->update($validateData);
        return redirect('admin/color')->with('message', "Color Updated Successfuly");
    }
    public function delete($color_id)
    {
        $colors = Color::findOrFail($color_id);
        $colors->delete();
        return redirect('admin/color')->with('message', 'Color Deletes SuccessFully');
    }
}
