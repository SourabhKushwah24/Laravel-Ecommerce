<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\SliderFormRequest;

class SliderController extends Controller
{

    public function index()
    {
        $sliders = DB::table('sliders')->paginate(3);
        return view('admin.slider.index', compact('sliders'));
    }
    public function create()
    {
        return view('admin.slider.create');
    }
    public function store(SliderFormRequest $request)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileExt = $file->getClientOriginalExtension();
            $filename = time() . '.' . $fileExt;
            $file->move('uploads/slider/', $filename);
            $validatedData['image'] = "uploads/slider/$filename";
        }

        $validatedData['status'] = $request->status == true ? '1' : '0';
        Slider::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'image' => $validatedData['image'],
            'status' => $validatedData['status'],
        ]);
        return redirect('admin/slider')->with('message', 'Slider Added SuccessFully');
    }

    public function edit(Slider $slider)
    {
        // $slider = Slider::findOrFail($slider_id);
        return view('admin.slider.edit', compact('slider'));
    }
    public function update(SliderFormRequest $request, Slider $slider)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            $destination = $slider->image;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $file = $request->file('image');
            $fileExt = $file->getClientOriginalExtension();
            $filename = time() . '.' . $fileExt;
            $file->move('uploads/slider/', $filename);
            $validatedData['image'] = "uploads/slider/$filename";
        }

        $validatedData['status'] = $request->status == true ? '1' : '0';
        Slider::where('id', $slider->id)->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'image' => $validatedData['image'] ?? $slider->image,
            'status' => $validatedData['status'],
        ]);
        return redirect('admin/slider')->with('message', 'Slider Updated SuccessFully');
    }

    public function delete(Slider $slider)
    {

        if ($slider->count() > 0) {
            if (File::exists($slider->image)) {
                File::delete($slider->image);
            }
            $slider->delete();
            return redirect('admin/slider')->with('message', 'Slider  Deleted SuccessFully');
        }
        return redirect('admin/slider')->with('message', 'Something went wrong');
    }
}
