<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = ['brand_id','car_model_id','year','mileage','color','user_id'];

    public function brand(){ return $this->belongsTo(Brand::class); }
    public function model(){ return $this->belongsTo(CarModel::class,'car_model_id'); }
    public function user(){ return $this->belongsTo(User::class); }
}
