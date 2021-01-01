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
        $table->id();
        $table->string('host');
        $table->string('up_down');
        $table->timestamp('created_at')->useCurrent();
        $table->timestamp('updated_at')->useCurrentOnUpdate()->default(\DB::raw('CURRENT_TIMESTAMP'));
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