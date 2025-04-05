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
        Schema::create('notif', function(Blueprint $table) {
            $table->string('notif_id', 38)->primary();
            $table->string('src_id', 35);
            $table->string('notif_user_id_sender', 35);
            $table->string('notif_user_id_reader', 35);
            $table->integer('notif_state');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('notif');
    }
};
