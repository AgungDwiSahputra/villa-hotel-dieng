<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\File;

class SettingController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:Setting Apps (Index)', only: ['index']),
        ];
    }

    public function index()
    {
        return view('admin.setting.index');
    }


    public function general(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'max:255'],
            'company' => ['required', 'max:255'],
            'header' => ['required'],
            'theme' => ['required'],
            'icon_size' => ['required'],
            'logo_size' => ['required'],
            'icon' => ['nullable', 'image', 'max:1000'],
            'logo' => ['nullable', 'image', 'max:1000'],
            'dp' => ['required','numeric'],
        ]);

        $datas = $validatedData;

      
        if ($request->hasFile('icon')) {
            $datas['icon'] = $request->file('icon')->storeAs('images/setting', 'icon.png' ,'public');
        }
     
        if ($request->hasFile('logo')) {
            $datas['logo'] = $request->file('logo')->storeAs('images/setting', 'logo.png' ,'public');
        }       

        $datas = array_filter($datas, function ($value) {
            return !is_null($value);
        });
        
        foreach ($datas as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }       

        return back()->with('success', 'General Settings Updated');
    }
    
    public function contact(Request $request)
    {
        $validatedData = $request->validate([
            'contact_email'     => ['required', 'max:255'],
            'contact_phone'     => ['required', 'max:255'],
            'contact_address'   => ['required', 'max:255'],
            'contact_maps'   => ['required'],
        ]);

        $datas = $validatedData;

        $datas = array_filter($datas, function ($value) {
            return !is_null($value);
        });
        
        foreach ($datas as $key => $value) {
           Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }       

        return back()->with('success', 'Contact Settings Updated');
    }
    
    public function sosmed(Request $request)
    {
        $validatedData = $request->validate([
            'sosmed_whatsapp'   => ['required','url', 'max:255'],
            'sosmed_instagram'  => ['required','url', 'max:255'],
            'sosmed_facebook'   => ['required','url', 'max:255'],
            'sosmed_tiktok'     => ['required','url', 'max:255'],
            'sosmed_youtube'    => ['required','url', 'max:255'],
        ]);

        $datas = $validatedData;

        $datas = array_filter($datas, function ($value) {
            return !is_null($value);
        });
        
        foreach ($datas as $key => $value) {
           Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }       

        return back()->with('success', 'Contact Settings Updated');
    }
    public function page(Request $request)
    {
        $validatedData = $request->validate([
            'page_about'   => ['required'],
            'page_terms'   => ['required'],
        ]);

        $datas = $validatedData;

        $datas = array_filter($datas, function ($value) {
            return !is_null($value);
        });
        
        foreach ($datas as $key => $value) {
           Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }       

        return back()->with('success', 'Page Settings Updated');
    }
}
