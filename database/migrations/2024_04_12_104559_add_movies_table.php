<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasColumn('movies', 'title')) {

        schema::table('movies', function(Blueprint $table) {
            $table->unique('title');
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
        if (Schema::hasColumn('movies', 'title')) {
            Schema::table('movies', function (Blueprint $table) {
                // 'title' 列の一意制約を削除する
                $table->dropUnique(['title']);
            });
        }
    }

}
