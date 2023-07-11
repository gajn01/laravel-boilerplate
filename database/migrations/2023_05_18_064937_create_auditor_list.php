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
        Schema::create('auditor_list', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('audit_date_id');
            $table->unsignedBigInteger('auditor_id');
            $table->string('auditor_name');
            $table->timestamps();

            // Define foreign key constraints, if applicable
            // $table->foreign('audit_date_id')->references('id')->on('audit_dates');
            // $table->foreign('auditor_id')->references('id')->on('auditors');
        });
    }

    public function down()
    {
        Schema::dropIfExists('auditor_list');
    }
};
