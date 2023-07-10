<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('summary', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('form_id');
            $table->integer('store_id');
            $table->string('code');
            $table->string('type');
            $table->string('conducted_by');
            $table->string('received_by')->nullable();
            $table->date('date_of_visit');
            $table->time('time_of_audit');
            $table->string('wave');
            $table->string('strength');
            $table->string('improvement');
            $table->integer('overall_score');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_summary');
    }
};
