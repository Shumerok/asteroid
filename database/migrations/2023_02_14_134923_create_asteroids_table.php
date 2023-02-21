<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asteroids', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('referenced')->unique();
            $table->string('name');
            $table->float('speed');
            $table->boolean('is_hazardous');
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asteroids');
    }
};
