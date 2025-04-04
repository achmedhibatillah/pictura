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
        Schema::create('user_to_post_like', function (Blueprint $table) {
            $table->string('relation_id', 35)->primary();
            $table->string('user_id', 35);
            $table->string('post_id', 35);
            $table->integer('like_status');
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('user')->onDelete('cascade');
            $table->foreign('post_id')->references('post_id')->on('post')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('post_like');
    }
};
