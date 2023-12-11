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
        Schema::create('Sub_coments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user_sub_coment');
                $table->foreign('id_user_sub_coment')->references('id')->on('users')->onDelete('cascade');;
            $table->unsignedBigInteger('id_coment');
                $table->foreign('id_coment')->references('id')->on('coments')->onDelete('cascade');;
            $table->text('the_sub_coment')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Sub_coments');
    }
};
