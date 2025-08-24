<?php
namespace App\Http\Controllers;
use App\Models\CarModel;
use Illuminate\Http\Request;
class CarModelController extends Controller {
    public function index(Request $r){
        $q=CarModel::query()->with('brand');
        if($r->has('brand_id')) $q->where('brand_id',$r->brand_id);
        return $q->get();
    }
}
