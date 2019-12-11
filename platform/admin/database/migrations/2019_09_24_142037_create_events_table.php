<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->string('slug', 120);
            $table->dateTime('date');
            $table->text('address')->nullable();
            $table->tinyInteger('status')->nullable()->default(1);
            $table->string('thumbnail', 191)->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('organizer_id');
            $table->foreign('organizer_id')
                ->references('id')
                ->on('organizers')
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
        Schema::dropIfExists('events');
    }
}
