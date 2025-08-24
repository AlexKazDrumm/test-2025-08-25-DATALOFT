<?php
namespace App\Http\Controllers;
use App\Models\Car;
use Illuminate\Http\Request;
class CarController extends Controller {
    public function index(){ return Car::with(['brand','model'])->get(); }
    public function store(Request $r){ return Car::create($r->all()); }
    public function show(Car $car){ return $car->load(['brand','model']); }
    public function update(Request $r, Car $car){ $car->update($r->all()); return $car; }
    public function destroy(Car $car){ $car->delete(); return response()->noContent(); }
}
