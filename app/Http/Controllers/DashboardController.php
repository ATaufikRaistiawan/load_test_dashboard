<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MachineData;
use App\Models\MachineLeftData;
use App\Models\MachineRightData;


class DashboardController extends Controller
{
    public function index()
    {
    // Fetch 20 latest records from both tables
    $leftData = MachineLeftData::orderBy('id', 'desc')->take(10)->get()->reverse();
    $rightData = MachineRightData::orderBy('id', 'desc')->take(10)->get()->reverse();

    // Extract data for charts or tables
    $leftTimestamps = $leftData->pluck('timestamp')->map(fn($t) => \Carbon\Carbon::parse($t)->format('H:i:s'));
    $leftRpm = $leftData->pluck('rpm');
    $leftRevs = $leftData->pluck('total_revs');
    $leftLoad = $leftData->pluck('load_kn');

    $rightTimestamps = $rightData->pluck('timestamp')->map(fn($t) => \Carbon\Carbon::parse($t)->format('H:i:s'));
    $rightRpm = $rightData->pluck('rpm');
    $rightRevs = $rightData->pluck('total_revs');
    $rightLoad = $rightData->pluck('load_kn');

    return view('dashboard', compact(
        'leftData',
        'rightData',
        'leftTimestamps',
        'leftRpm',
        'leftRevs',
        'leftLoad',
        'rightTimestamps',
        'rightRpm',
        'rightRevs',
        'rightLoad'
    ));
    }
//     public function getData()
// {
//     $data = MachineData::latest()->take(10)->get()->reverse(); // or whatever query you use

//     return response()->json([
//         'timestamps' => $data->pluck('timestamp'),
//         'rpm' => $data->pluck('rpm'),
//         'load' => $data->pluck('load_kn'),
//         'rows' => $data
//     ]);
// }
    public function getLatestJson()
{
    $left = MachineLeftData::latest('timestamp')->first();
    $right = MachineRightData::latest('timestamp')->first();

    return response()->json([
        'left' => $left,
        'right' => $right,
    ]);
}



}
