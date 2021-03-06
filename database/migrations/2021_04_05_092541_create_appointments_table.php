<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id');
            $table->foreignId('patient_id');
            $table->foreignId('doctor_schedule_id')->nullable();
            $table->string('appointment_number');
            $table->longText('reason');
            $table->string('time');
            $table->integer('status')->default(0);
            $table->foreignId('referred_from')->nullable();
            $table->foreignId('referred_to')->nullable();
            $table->string('type');
            $table->string('meeting_link')->nullable();
            $table->boolean('isPaid')->default(false);
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
        Schema::dropIfExists('appointments');
    }
}
