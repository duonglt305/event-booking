<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSessionRegistrationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('session_registration', function (Blueprint $table) {
            $table->unsignedBigInteger('registration_id');
            $table->unsignedBigInteger('session_id');
            $table->double('cost');
            $table->timestamp('attended_at')->nullable();
            $table->foreign('registration_id')
                ->references('id')
                ->on('registrations')
                ->onDelete('cascade');
            $table->foreign('session_id')
                ->references('id')
                ->on('sessions')
                ->onDelete('cascade');
            $table->primary(['registration_id', 'session_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('session_registration');
    }
}
