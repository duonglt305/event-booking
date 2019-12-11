<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('attendee_id');
            $table->unsignedBigInteger('ticket_id');
            $table->enum('status', ['PENDING', 'PAID'])->default('PENDING');
            $table->text('verify_history')->nullable();
            $table->foreign('attendee_id')
                ->references('id')
                ->on('attendees')
                ->onDelete('cascade');
            $table->foreign('ticket_id')
                ->references('id')
                ->on('tickets')
                ->onDelete('cascade');
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
        Schema::dropIfExists('registrations');
    }
}
