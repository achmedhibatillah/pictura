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
        Schema::create('post', function(Blueprint $table) {
            $table->string('post_id', 35)->primary();
            $table->string('post_public_id', 55)->unique();
            $table->string('post_desc', 350)->nullable();
            $table->integer('post_status')->default(3);
            $table->string('user_id', 35);
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('post');
    }
};
