<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MachineData;

class HistoryController extends Controller
{
    public function index()
    {
        $data = MachineData::orderBy('timestamp', 'desc')->paginate(20);
        return view('history', compact('data'));
    }
}