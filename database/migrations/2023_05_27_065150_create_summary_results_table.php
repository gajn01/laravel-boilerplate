<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('summary_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('summary_id');
            $table->unsignedBigInteger('store_id');
            $table->string('category');
            $table->integer('score');
            $table->integer('percentage');
            $table->text('remarks')->nullable();
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('summary_results');
    }
};
