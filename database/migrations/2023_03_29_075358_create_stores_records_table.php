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
        Schema::create('store_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id');
            $table->string('wave1');
            $table->integer('wave1_form');
            $table->string('wave2');
            $table->integer('wave2_form');
            $table->unsignedBigInteger('audit_form_id');
            $table->foreign('store_id')->references('id')->on('stores');
            $table->foreign('audit_form_id')->references('id')->on('audit_forms');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_records');
    }
};
