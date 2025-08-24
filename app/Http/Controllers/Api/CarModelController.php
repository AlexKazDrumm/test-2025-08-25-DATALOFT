<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CarModel;
use Illuminate\Http\Request;

class CarModelController extends Controller
{
    public function index(Request $request)
    {
        $q = CarModel::query()->with('brand')->orderBy('name');
        if ($request->filled('brand_id')) {
            $q->where('brand_id', (int)$request->brand_id);
        }
        return $q->get();
    }
}
