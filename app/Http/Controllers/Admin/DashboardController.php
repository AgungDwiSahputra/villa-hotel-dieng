<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jaringan\Jaringan;
use App\Models\Jaringan\JaringanUnitSr;
use App\Models\Produksi\Produksi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request){
        // auth()->user()->tokens()->delete();
        return view('admin.dashboard.index');
    }
}
