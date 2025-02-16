<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Part;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::query();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('name', 'LIKE', '%' . $search . '%')->orwhere('registration_number', 'LIKE', '%' . $search . '%');
        }

        $cars = $query->latest()->paginate(5);

        return response()->json([
            'code' => 200,
            'msg' => 'Cars list',
            'data' => $cars
        ]);
    }

    public function detail($carId)
    {
        $car = Car::findOrFail($carId);
        return response()->json([
                'code' => 200,
                'msg' => 'Car detail',
                'data' => $car
            ]
        );
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

        return response()->json([
            'code' => 200,
            'msg' => 'Car created successfully',
            'data' => null
        ]);
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

        return response()->json([
            'code' => 200,
            'msg' => 'Car updated successfully',
        ]);
    }

    public function delete($carId)
    {
        Car::findOrFail($carId)->delete();
        Part::where('car_id', $carId)->delete();
        return response()->json([
            'code' => 200,
            'msg' => 'Car deleted successfully',
        ]);
    }
}
