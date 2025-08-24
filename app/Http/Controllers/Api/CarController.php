<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index(Request $request)
    {
        return Car::query()
            ->where('user_id', $request->user()->id)
            ->with(['brand','model'])
            ->orderByDesc('id')
            ->get();
    }

    public function store(StoreCarRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $car = Car::create($data);
        return $car->load(['brand','model']);
    }

    public function show(Request $request, Car $car)
    {
        $this->authorize('view', $car);
        return $car->load(['brand','model']);
    }

    public function update(UpdateCarRequest $request, Car $car)
    {
        $this->authorize('update', $car);
        $car->update($request->validated());
        return $car->load(['brand','model']);
    }

    public function destroy(Request $request, Car $car)
    {
        $this->authorize('delete', $car);
        $car->delete();
        return response()->noContent();
    }
}
