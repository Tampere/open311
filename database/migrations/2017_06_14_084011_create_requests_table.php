<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->uuid('service_request_id');
            $table->string('service_code');
            $table->string('status')->default('pending');
            $table->text('status_notes')->nullable();
            $table->string('agency_responsible')->nullable();
            $table->text('description');
            $table->string('title')->nullable();
            $table->string('address_string')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('email')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('media_url')->nullable();
            $table->timestamps();

            $table->foreign('service_code')
                ->references('service_code')
                ->on('services')
                ->onDelete('cascade');

            $table->primary('service_request_id');
        });

        DB::statement('ALTER TABLE requests ADD location POINT' );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests');
    }
}
