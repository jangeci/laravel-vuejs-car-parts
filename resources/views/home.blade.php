@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <form class="d-flex w-100">
                            <input
                                class="form-control flex-grow-1"
                                value="{{ request()->query('search', '') }}"
                                type="text"
                                name="search"
                                placeholder="Search by name or reg number"/>
                            <button type="submit" class="btn">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>
                    </div>

                    <div class="py-12">
                        <div class="container">
                            <div class="row">
                                <cars-list :cars="{{ json_encode($cars->items())}}"></cars-list>
                                {{$cars->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        Add new
                    </div>
                    <div class="card-body">
                        <form action="{{route('car.create')}}" method="POST">
                            @csrf
                            <input type="hidden" name="is_registered" value="0">
                            <div class="form-group pb-3">
                                <label class="form-label col-12">Car name
                                    <input class="form-control" name="name" type="text" value="{{ old('name') }}">
                                </label>
                                @error('name')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="form-group pb-3 d-flex">
                                <input
                                    class="form-check-input me-2"
                                    name="is_registered"
                                    type="checkbox"
                                    id="is_registered"
                                    value="1"
                                    {{ old('is_registered', $car->is_registered ?? 0) ? 'checked' : '' }}
                                >
                                <label class="form-label" for="is_registered">Is registered</label>
                            </div>

                            <div class="form-group pb-3">
                                <label class="form-label col-12">Registration number
                                    <input class="form-control" name="registration_number" type="text" value="{{ old('registration_number') }}">
                                </label>
                                @error('registration_number')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Add Car</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
