<?php
namespace App\Http\Controllers;
use App\Models\Brand;
class BrandController extends Controller {
    public function index(){ return Brand::all(); }
}
