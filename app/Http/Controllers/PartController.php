<?php

namespace App\Http\Controllers;

use App\Models\Part;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PartController extends Controller
{
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

    public function edit($partId)
    {
        $part = DB::table('parts')->where('id', $partId)->first();

        return view('part.edit', compact('part'));
    }

    public function update(Request $request, $partId)
    {
        $request->validate([
            'name' => 'required',
            'car_id' => 'required',
        ]);

        Part::findOrFail($partId)->update([
            'name' => $request['name'],
            'car_id' => $request['car_id'],
            'serial_number' => $request['serial_number'],
        ]);

        $notification = array(
            'message' => 'Part created successfully',
            'alert-type' => 'success',
        );

        return Redirect()->back()->with($notification);
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
