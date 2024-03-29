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
        Schema::create('audit_forms', function (Blueprint $table) {
            $table->id();
            $table->integer('store_id');
            $table->date('audit_date');
            $table->date('date_of_visit');
            $table->string('conducted_by_id');
            $table->longText('audit_result');
            $table->string('received_by')->nullable();
            $table->string('strength')->nullable();
            $table->string('improvement')->nullable();
            $table->time('time_of_audit');
            $table->integer('wave');
            $table->integer('audit_status');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_forms');
    }
};
