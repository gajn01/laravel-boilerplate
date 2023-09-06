<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ActivityLog;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address');
            $table->string('device');
            $table->string('browser');
            $table->string('platform');
            $table->string('activity');
            $table->bigInteger('created_by_id')->unsigned()->nullable();
            $table->foreign('created_by_id')->references('id')->on('user')->restrictOnDelete();
            $table->timestamp(ActivityLog::CREATED_AT)->nullable();
            $table->timestamp(ActivityLog::UPDATED_AT)->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_logs');
    }
};
