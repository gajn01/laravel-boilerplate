<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('critical_deviations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('critical_deviation_menu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('critical_deviation_id');
            $table->string('label');
            $table->text('remarks')->nullable();
            $table->foreignId('score_dropdown_id')->nullable();
            $table->boolean('is_location')->nullable()->default(false);
            $table->foreignId('location_dropdown_id')->nullable();
            $table->boolean('is_product')->nullable()->default(false);
            $table->foreignId('product_dropdown_id')->nullable();
            $table->boolean('is_sd')->nullable()->default(false);
            $table->boolean('is_dropdown')->nullable()->default(false);
            $table->foreignId('dropdown_id')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('critical_deviation_menu');
        Schema::dropIfExists('critical_deviations');
    }
};
