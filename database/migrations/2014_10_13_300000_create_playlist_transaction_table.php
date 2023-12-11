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
        Schema::create('play_list_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_video');
                $table->foreign('id_video')->references('id')->on('videos')->onDelete('cascade');
            $table->unsignedBigInteger('id_playlist');
                $table->foreign('id_playlist')->references('id')->on('play_lists')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('play_list_transactions');
    }
};
// *********************************
// // tkamel remove ta3 videos mel playlist
// // tkamel kif tfase5 play list ta3mel have_playlist = false
// ********************************