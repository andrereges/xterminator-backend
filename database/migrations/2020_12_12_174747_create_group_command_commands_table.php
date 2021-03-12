<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupCommandCommandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_command_commands', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_command_id');
            $table->unsignedBigInteger('command_id');
            $table->timestamps();

            $table->foreign('group_command_id')->references('id')->on('group_commands');
            $table->foreign('command_id')->references('id')->on('commands');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_command_commands');
    }
}
