<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
  public function up(){ Schema::create('cars', function(Blueprint $t){$t->id();$t->foreignId('brand_id')->constrained()->cascadeOnDelete();$t->foreignId('car_model_id')->constrained()->cascadeOnDelete();$t->unsignedSmallInteger('year')->nullable();$t->unsignedInteger('mileage')->nullable();$t->string('color',64)->nullable();$t->foreignId('user_id')->constrained()->cascadeOnDelete();$t->timestamps();}); }
  public function down(){ Schema::dropIfExists('cars'); }
};
