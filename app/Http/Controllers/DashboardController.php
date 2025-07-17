<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MachineData;

class DashboardController extends Controller
{
    public function index()
    {
        $data = MachineData::orderBy('timestamp', 'desc')->take(10)->get()->reverse();
        
        $timestamps = $data->pluck('timestamp')->map(function ($t) {
            return \Carbon\Carbon::parse($t)->format('H:i:s');
        });
        $rpm = $data->pluck('rpm');
        $revs = $data->pluck('total_revs');
        $load = $data->pluck('load_kn');

        return view('dashboard', compact('data', 'timestamps', 'rpm', 'revs', 'load'));
    }
}
