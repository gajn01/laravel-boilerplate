<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('service_speed', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id');
            $table->boolean('is_cashier')->nullable();
            $table->string('name')->nullable();
            $table->time('time')->nullable();
            $table->string('product_ordered')->nullable();
            $table->boolean('ot')->nullable();
            $table->boolean('assembly')->nullable();
            $table->integer('base_assembly_points')->nullable();
            $table->integer('assembly_points')->nullable();
            $table->time('tat')->nullable();
            $table->integer('base_tat_points')->nullable();
            $table->integer('tat_points')->nullable();
            $table->boolean('fst')->nullable();
            $table->integer('base_fst_points')->nullable();
            $table->integer('fst_points')->nullable();
            $table->string('remarks')->nullable();
            $table->dateTime('serving_time')->nullable();
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('service_speed');
    }
};
