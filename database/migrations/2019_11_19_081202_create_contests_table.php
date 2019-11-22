<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('competition_id')->index();
            $table->string('name');
            $table->string('implementation_intructions')->nullable();
            $table->string('technical_instructions')->nullable();
            $table->string('limit')->nullable();
            $table->text('terms_and_conditions')->nullable();
            $table->timestamps();
            $table->softdeletes();

            $table->foreign('competition_id')->references('id')->on('competitions')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contests');
    }
}
