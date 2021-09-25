<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRafflesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raffles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('item_id');
            $table->integer('winner_id')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('max_tickets_number')->nullable();
            $table->integer('tickets_number')->default(0)->nullable();
            $table->integer('progress')->default(0)->nullable();
            $table->integer('status')->default(0)->nullable()->comment('0 not raffled | 1 raffled');
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
        Schema::dropIfExists('raffles');
    }
}
