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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
                $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('id_chanel');
                $table->foreign('id_chanel')->references('id')->on('chanels')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->text('discription')->nullable();
            $table->string('video_path')->nullable();
            $table->string('img_path')->nullable();
            $table->string('duration')->nullable();
            $table->boolean('main_video')->default(false);
            $table->string('public')->nullable();
            $table->boolean('strik')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
