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
        Schema::create('user_to_user_connect', function (Blueprint $table) {
            $table->string('relation_id', 35)->primary();
            $table->string('user_id_src', 35);
            $table->string('user_id_dst', 35);
            $table->integer('connect_status');
            $table->timestamps();
        
            $table->foreign('user_id_src')->references('user_id')->on('user')->onDelete('cascade');
            $table->foreign('user_id_dst')->references('user_id')->on('user')->onDelete('cascade');
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('user_to_user_connect');
    }
};
