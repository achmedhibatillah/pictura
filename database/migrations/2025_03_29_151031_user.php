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
        Schema::create('user', function(Blueprint $table) {
            $table->string('user_id', 35)->primary();
            $table->string('user_username', 35)->unique();
            $table->string('user_fullname', 255)->nullable();
            $table->string('user_desc', 350)->nullable();
            $table->string('user_email', 255);
            $table->string('user_pass', 255);
            $table->string('user_photo', 255)->nullable();
            $table->integer('user_who');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('user');
    }
};
