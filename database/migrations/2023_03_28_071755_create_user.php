<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('contact_number',30);
            $table->tinyInteger('user_type');
            $table->boolean('is_active');
            $table->longText('user_access');
            $table->bigInteger('created_by_id')->unsigned()->nullable();
            $table->bigInteger('last_updated_by_id')->unsigned()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamp(User::CREATED_AT)->nullable();
            $table->timestamp(User::UPDATED_AT)->nullable();
            $table->timestamps();
            $table->foreign('created_by_id')->references('id')->on('user')->restrictOnDelete();
            $table->foreign('last_updated_by_id')->references('id')->on('user')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
