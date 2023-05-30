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
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('slug');
            $table->mediumText('description');
            $table->boolean('visible')->default(true);
            $table->smallInteger('mq');
            $table->string('address');
            $table->string('latitude');
            $table->string('longitude');
            $table->tinyInteger('beds');
            $table->tinyInteger('total_rooms');
            $table->tinyInteger('baths');
            $table->string('media');
            $table->tinyInteger('guests')->nullable();
            $table->string('check_in')->nullable();
            $table->string('check_out')->nullable();
            $table->float('price', 5, 2)->nullable();
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
        Schema::dropIfExists('apartments');
    }
};
