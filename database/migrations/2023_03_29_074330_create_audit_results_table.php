<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('audit_results', function (Blueprint $table) {
            $table->id();
            $table->integer('form_id');
            $table->integer('category_id');
            $table->string('category_name');
            $table->integer('sub_category_id')->nullable();
            $table->string('sub_name')->nullable();
            $table->integer('sub_base_point')->nullable();
            $table->integer('sub_point')->nullable();
            $table->string('sub_remarks')->nullable();
            $table->string('sub_file')->nullable();
            $table->integer('sub_sub_category_id')->nullable();
            $table->string('sub_sub_name')->nullable();
            $table->integer('sub_sub_base_point')->nullable();
            $table->integer('sub_sub_point')->nullable();
            $table->string('sub_sub_remarks')->nullable();
            $table->string('sub_sub_file')->nullable();
            $table->string('sub_sub_deviation')->nullable();
            $table->string('is_na')->nullable();
            $table->integer('label_id')->nullable();
            $table->string('label_name')->nullable();
            $table->integer('label_base_point')->nullable();
            $table->integer('label_point')->nullable();
            $table->string('label_remarks')->nullable();
            $table->string('label_deviation')->nullable();
            $table->string('label_file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_results');
    }
};
