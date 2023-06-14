<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::first();
        return view('admin.setting.index', compact('settings'));
    }
    public function store(Request $request)
    {
        $settings = Setting::first();
        if ($settings) {
            // update data 
            $settings->update([
                'website_name' => $request->website_name,
                'website_url' => $request->website_url,
                'title' => $request->title,
                'meta_keyword' => $request->meta_keyword,
                'meta_description' => $request->meta_description,
                'phone1' => $request->phone1,
                'phone2' => $request->phone2,
                'email1' => $request->email1,
                'email2' => $request->email2,
                'address' => $request->address,
                'facebook' => $request->facebook,
                'twitter' => $request->twitter,
                'instagram' => $request->instagram,
                'youtube' => $request->youtube,
            ]);
            return redirect()->back()->with('message', 'Setting Update SuccessFully');
        } else {
            // create data 
            Setting::create([
                'website_name' => $request->website_name,
                'website_url' => $request->website_url,
                'title' => $request->title,
                'meta_keyword' => $request->meta_keyword,
                'meta_description' => $request->meta_description,
                'phone1' => $request->phone1,
                'phone2' => $request->phone2,
                'email1' => $request->email1,
                'email2' => $request->email2,
                'address' => $request->address,
                'facebook' => $request->facebook,
                'twitter' => $request->twitter,
                'instagram' => $request->instagram,
                'youtube' => $request->youtube,
            ]);
            return redirect()->back()->with('message', 'Setting Created SuccessFully');
        }
    }
}
