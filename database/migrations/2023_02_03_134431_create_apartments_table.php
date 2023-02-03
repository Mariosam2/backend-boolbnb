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
            $table->string('title', 50);
            $table->mediumText('description');
            $table->boolean('visible')->default(true);
            $table->smallInteger('square_meters');
            $table->string('latitude');
            $table->string('longitude');
            $table->tinyInteger('guests')->nullable();
            $table->tinyInteger('baths')->nullable();
            $table->string('address')->nullable();
            $table->date('check_in')->nullable();
            $table->date('check_out')->nullable();
            $table->float('price', 5, 2)->nullable();
            $table->string('media')->nullable();
            $table->tinyInteger('bedrooms')->nullable();
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
