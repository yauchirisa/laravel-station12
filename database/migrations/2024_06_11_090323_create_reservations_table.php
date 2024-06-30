<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('schedule_id')->index();
            $table->foreign('schedule_id')->references('id')->on('schedules')->cascadeOnUpdate()->cascadeOnDelete();
            $table->unsignedBigInteger('sheet_id')->index();
            $table->foreign('sheet_id')->references('id')->on('sheets')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('email');
            $table->string('name');
            $table->boolean('is_canceled')->default(false);
            $table->timestamps();

            $table->unique(['schedule_id', 'sheet_id'], 'id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
