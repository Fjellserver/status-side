<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Status extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    Schema::create('status', function (Blueprint $table) {
        $table->string('host');
        $table->string('up_down');
        $tabel->string('down_count');
        $table->string('rank');
        $table->string('created_at');
    });
}

/**
 * Reverse the migrations.
 *
 * @return void
 */
public function down()
{
    Schema::drop('status');
}
}