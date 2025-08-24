<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
  public function up(){ Schema::create('car_models', function(Blueprint $t){$t->id();$t->foreignId('brand_id')->constrained()->cascadeOnDelete();$t->string('name');$t->timestamps();$t->unique(['brand_id','name']);}); }
  public function down(){ Schema::dropIfExists('car_models'); }
};
