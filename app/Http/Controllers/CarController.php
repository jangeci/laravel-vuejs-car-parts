<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Part;
use Illuminate\Http\Request;

class CarController extends Controller
{

    public function detail(Request $request, $carId)
    {
        $car = Car::find($carId)->first();

        $query = Part::query();
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('name', 'LIKE', '%' . $search . '%')->orwhere('serial_number', 'LIKE', '%' . $search . '%');
        }
        $parts = $query->latest()->paginate(10);

        return view('car.detail', compact('car', 'parts'));
    }

    public function index(Request $request)
    {
        $query = Car::query();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('name', 'LIKE', '%' . $search . '%')->orwhere('registration_number', 'LIKE', '%' . $search . '%');
        }

        $cars = $query->latest()->paginate(10);

        return view('home', compact('cars'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'registration_number' => 'required_if:is_registered,1',
        ]);

        Car::insert([
            'name' => $request['name'],
            'registration_number' => $request['registration_number'],
            'is_registered' => $request['is_registered'],
        ]);

        $notification = array(
            'message' => 'Car created successfully',
            'alert-type' => 'success',
        );

        return Redirect()->back()->with($notification);
    }

    public function edit($carId)
    {
        $car = DB::table('cars')->where('id', $carId)->first();
        return view('car-edit', compact('car'));
    }

    public function update(Request $request, $carId)
    {
        $request->validate([
            'name' => 'required',
            'registration_number' => 'required_if:is_registered,1',
        ]);

        Car::find($carId)->update([
            'name' => $request['name'],
            'registration_number' => $request['registration_number'],
            'is_registered' => $request['is_registered'],
        ]);

        return Redirect()->back()->with('success', 'Car updated successfully');
    }

    public function delete($carId)
    {
        Car::find($carId)->delete();
        return Redirect()->back()->with('success', 'Car deleted successfully');
    }
}
