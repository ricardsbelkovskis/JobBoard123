<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('favorite_diy_user', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('diy_id');
            $table->timestamps();
    
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('diy_id')->references('id')->on('diys')->onDelete('cascade');
            
            $table->primary(['user_id', 'diy_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('favorite_diy_user');
    }
};
