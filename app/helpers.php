<?php

use App\Models\Hewan\HewanUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

if (!function_exists('storeImage')) {
    function storeImage(Request $request, $field, $module)
    {
        $modelClass = "App\\Models\\{$module}";
        if ($request->id) {
            $oldFile = $modelClass::find($request->id);
            if ($oldFile && $oldFile->$field) {
                Storage::disk('public')->delete($oldFile->$field);
            }
        }
        
        $modulePath = strtolower(str_replace('\\', '/', $module));

        return $request->file($field)->store('images/'.$modulePath,'public');
    }
    function storeMultipleImage($image, $module)
    {
        $modulePath = strtolower(str_replace('\\', '/', $module));
        return $image->store('images/'.$modulePath,'public');
    }

    function storeFile(Request $request, $field, $module)
    {
        $modelClass = "App\\Models\\{$module}";
        if ($request->id) {
            $oldFile = $modelClass::find($request->id);
            if ($oldFile && $oldFile->$field) {
                Storage::disk('public')->delete($oldFile->$field);
            }
        }
        
        $modulePath = strtolower(str_replace('\\', '/', $module));

        return $request->file($field)->store('file/'.$modulePath,'public');
    }
}