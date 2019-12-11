<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('firstname', 25);
            $table->string('lastname', 25);
            $table->string('username', 100)->unique();
            $table->string('password', 100);
            $table->string('email', 100)->unique();
            $table->string('registration_code', 40)->unique()->index();
            $table->string('verify_code', 100)->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
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
        Schema::dropIfExists('attendees');
    }
}
