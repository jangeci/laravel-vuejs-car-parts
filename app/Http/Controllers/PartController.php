<?php

namespace App\Http\Controllers;

use App\Models\Part;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PartController extends Controller
{
    public function detail($carId, $partId)
    {
        $part = Part::findOrFail($partId);
        return response()->json([
                'code' => 200,
                'msg' => 'Part detail',
                'data' => $part
            ]
        );
    }

    public function create(Request $request, $carId)
    {
        $request->validate([
            'name' => 'required',
            'serial_number' => 'required',
        ]);

        Part::insert([
            'name' => $request['name'],
            'car_id' => $carId,
            'serial_number' => $request['serial_number'],
            'created_at' => Carbon::now()
        ]);

        return response()->json([
            'code' => 200,
            'msg' => 'Part created successfully',
        ]);
    }

    public function update(Request $request, $carId, $partId)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Part::findOrFail($partId)->update([
            'name' => $request['name'],
            'serial_number' => $request['serial_number'],
        ]);

        return response()->json([
            'code' => 200,
            'msg' => 'Part deleted successfully',
        ]);
    }

    public function delete($carId, $partId)
    {
        Part::findOrFail($partId)->delete();
        return response()->json([
            'code' => 200,
            'msg' => 'Part deleted successfully',
        ]);
    }
}
