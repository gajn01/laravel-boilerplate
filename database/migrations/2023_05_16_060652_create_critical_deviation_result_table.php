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
        Schema::create('critical_deviation_result', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id');
            $table->unsignedBigInteger('critical_deviation_id');
            $table->string('remarks')->nullable();
            $table->string('score')->nullable();
            $table->string('sd')->nullable();
            $table->string('location')->nullable();
            $table->string('product')->nullable();
            $table->string('dropdown')->nullable();
            $table->timestamps();

            $table->foreign('form_id')->references('id')->on('audit_forms');
            $table->foreign('critical_deviation_id')->references('id')->on('critical_deviation_menus');
        });
    }
    public function down()
    {
        Schema::dropIfExists('critical_deviation_result');
    }
};