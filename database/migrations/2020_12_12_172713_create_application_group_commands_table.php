<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationGroupCommandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_group_commands', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_command_id');
            $table->unsignedBigInteger('application_id');
            $table->timestamps();

            $table->foreign('group_command_id')->references('id')->on('group_commands');
            $table->foreign('application_id')->references('id')->on('applications');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('application_group_commands');
    }
}
