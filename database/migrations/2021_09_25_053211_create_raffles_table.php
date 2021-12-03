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
            $table->id();
            $table->bigInteger('item_id')->unsigned();
            $table->integer('winner_id')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('max_tickets_number')->nullable();
            $table->integer('raffle_goal_amount')->nullable();
            $table->integer('tickets_number')->default(0)->nullable();
            $table->integer('progress')->default(0)->nullable();
            $table->integer('active')->default(0)->nullable()->comment('0 show in app | 1 hide in app');
            $table->integer('status')->default(0)->nullable()->comment('0 not raffled | 1 raffled');
            $table->timestamps();

            $table->foreign('item_id')->references('id')
                ->on('items')->onUpdate('cascade')->onDelete('cascade');
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
