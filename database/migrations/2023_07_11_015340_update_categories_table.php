<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('categories',function(Blueprint $table){
            $table->integer('order');
            $table->integer('ros')->nullable();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories',function(Blueprint $table){
            $table->dropColumn(['order']);
            $table->dropColumn(['ros']);
        });
    }
};
