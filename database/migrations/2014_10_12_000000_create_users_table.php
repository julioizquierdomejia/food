<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->string('dni')->unique();
            $table->string('phone')->unique();

            $table->text('uri_image')->nullable();
            $table->text('name_image')->nullable();

            $table->boolean('status')->default(1);

            $table->unsignedBigInteger('area_id')->nullable();
            $table->unsignedBigInteger('stall_id')->nullable();
            
            $table->text('token')->nullable();
            $table->boolean('active')->nullable();
            $table->text('device_token')->nullable();
            $table->text('reset_token')->nullable();
            $table->integer('role')->default(0);
            //$table->text('bio')->nullable();
            
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
