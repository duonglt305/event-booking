<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_ratings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('rate');
            $table->unsignedBigInteger('attendee_id');
            $table->unsignedBigInteger('event_id');
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->foreign('attendee_id')
                ->references('id')
                ->on('attendees')
                ->onDelete('cascade');
            $table->foreign('event_id')
                ->references('id')
                ->on('events')
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
        Schema::dropIfExists('event_ratings');
    }
}
