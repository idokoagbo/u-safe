<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncidentResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incident_responses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('response_type');
            $table->integer('response_code')->nullable();
            $table->integer('status')->default(0);
            $table->text('geolocation')->nullable();
            $table->text('description')->nullable();
            $table->string('file_attach1')->nullable();
            $table->string('file_attach2')->nullable();
            $table->string('file_attach3')->nullable();
            $table->string('file_attach4')->nullable();
            $table->string('file_attach5')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incident_responses');
    }
}
