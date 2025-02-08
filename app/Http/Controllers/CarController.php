<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Part;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CarController extends Controller
{

    public function detail(Request $request, $carId)
    {
        $car = Car::findOrFail($carId)->first();

        $query = Part::where('car_id', $carId);
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
        ], [
            'registration_number.required_if' => 'Registration number is required'
        ]);

        Car::insert([
            'name' => $request['name'],
            'registration_number' => $request['registration_number'],
            'is_registered' => $request['is_registered'] ?? 0,
            'created_at' => Carbon::now()
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

        Car::findOrFail($carId)->update([
            'name' => $request['name'],
            'registration_number' => $request['registration_number'],
            'is_registered' => $request['is_registered'],
        ]);

        return Redirect()->back()->with('success', 'Car updated successfully');
    }

    public function delete($carId)
    {
        Car::findOrFail($carId)->delete();
        return Redirect()->back()->with('success', 'Car deleted successfully');
    }
}
