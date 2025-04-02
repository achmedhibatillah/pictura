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
        Schema::create('slide', function(Blueprint $table) {
            $table->string('slide_id', 35)->primary();
            $table->string('slide_image', 255);
            $table->integer('slide_order');
            $table->string('post_id', 35);
            $table->timestamps();

            $table->foreign('post_id')->references('post_id')->on('post')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('slide');
    }
};
