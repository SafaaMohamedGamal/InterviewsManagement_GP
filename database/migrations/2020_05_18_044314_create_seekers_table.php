<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeekersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seekers', function (Blueprint $table) {
            $table->id();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('seniority')->nullable();
            $table->integer('expYears')->nullable();
            $table->string('currentJob')->nullable();
            $table->unsignedInteger('currentSalary')->nullable();
            $table->unsignedInteger('expectedSalary')->nullable();
            $table->string('cv')->nullable();
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
        Schema::dropIfExists('seekers');
    }
}
