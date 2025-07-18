<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Models\MachineData;

class StatusApiController extends Controller
{
    public function status()
    {
        // Get the latest data row
        $latest = MachineData::latest('timestamp')->first();

        // You’ll need to define how to detect "running" vs "stopped"
        $leftStatus = $latest && $latest->rpm > 0 ? 'running' : 'stopped';
        $rightStatus = $latest && $latest->load_kn > 0 ? 'running' : 'stopped';

        return response()->json([
            'left' => $leftStatus,
            'right' => $rightStatus,
        ]);
    }
}
