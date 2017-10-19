<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_updates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('service_request_id');
            $table->text('old_value');
            $table->text('new_value');
            $table->unsignedInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('service_request_id')
                ->references('service_request_id')
                ->on('requests')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_updates');
    }
}
