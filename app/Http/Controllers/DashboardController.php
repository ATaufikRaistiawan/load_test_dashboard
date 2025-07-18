<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MachineData;

class DashboardController extends Controller {
    public function index() {
        $data=MachineData::orderBy('timestamp', 'desc')->take(20)->get()->reverse();

        $timestamps=$data->pluck('timestamp')->map(function ($t) {
                return \Carbon\Carbon::parse($t)->format('H:i:s');
            });
        $rpm=$data->pluck('rpm');
        $revs=$data->pluck('total_revs');
        $load=$data->pluck('load_kn');

        return view('dashboard', compact('data', 'timestamps', 'rpm', 'revs', 'load'));
    }

    public function getData() {
        $data=MachineData::latest()->take(10)->get()->reverse(); // or whatever query you use

        return response()->json([ 'timestamps'=> $data->pluck('timestamp'),
            'rpm'=> $data->pluck('rpm'),
            'load'=> $data->pluck('load_kn'),
            'rows'=> $data]);


    }

    public function getStatus() {
        $leftMachine=MachineData::where('stage', 'left')->latest()->first();
        $rightMachine=MachineData::where('stage', 'right')->latest()->first();

        return response()->json([ 'left'=> $leftMachine->status, // running or stopped
            'right'=> $rightMachine->status,
            ]);
    }


}
