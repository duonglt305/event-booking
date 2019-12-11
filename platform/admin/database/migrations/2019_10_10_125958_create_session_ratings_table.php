<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('session_ratings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('rate');
            $table->unsignedBigInteger('attendee_id');
            $table->unsignedBigInteger('session_id');
            $table->timestamps();
            $table->foreign('attendee_id')
                ->references('id')
                ->on('attendees')
                ->onDelete('cascade');
            $table->foreign('session_id')
                ->references('id')
                ->on('sessions')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('session_ratings');
    }
}
