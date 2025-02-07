<?php

namespace App\Http\Controllers;

use App\Models\Part;
use Illuminate\Http\Request;

class PartController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'car_id' => 'required',
        ]);

        Part::insert([
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

        Part::find($partId)->update([
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

    public function delete($partId)
    {
        Part::find($partId)->delete();
        return Redirect()->back()->with('success', 'Part deleted successfully');
    }
}
