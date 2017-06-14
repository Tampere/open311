<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeywordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keywords', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('keyword_service', function(Blueprint $table) {
            $table->string('service_code');
            $table->unsignedInteger('keyword_id');

            $table->foreign('service_code')
                ->references('service_code')
                ->on('services')
                ->onDelete('cascade');

            $table->foreign('keyword_id')
                ->references('id')
                ->on('keywords')
                ->onDelete('cascade');

            $table->primary(['service_code', 'keyword_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keyword_service');
        Schema::dropIfExists('keywords');
    }
}
