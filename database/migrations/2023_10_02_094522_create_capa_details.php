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
        Schema::create('capa_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('capa_id');
            $table->string('complaint_details');
            $table->string('why_1');
            $table->string('why_2');
            $table->string('why_3');
            $table->string('why_4');
            $table->string('corrective_action');
            $table->string('responsible');
            $table->string('timeline');
            $table->string('preventive_action');
            $table->string('responsibe');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capa_details');
    }
};
