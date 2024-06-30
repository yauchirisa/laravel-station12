<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('schedules')) {
            Schema::create('schedules', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('movie_id')->index();
                $table->foreign('movie_id')->references('id')->on('movies')->cascadeOnUpdate()->cascadeOnDelete();
                $table->unsignedBigInteger('screen_id')->nullable()->index();
                $table->foreign('screen_id')->references('id')->on('screens')->cascadeOnUpdate()->cascadeOnDelete();
                $table->datetime('start_time');
                $table->datetime('end_time');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // スケジュールテーブルの削除
        Schema::dropIfExists('schedules');

    }
}
