<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserContestScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_contest_scores', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('contest_valuation_id')->index();
            $table->uuid('user_id')->index();
            $table->uuid('judge_id')->index();
            $table->string('score');
            $table->timestamps();

            $table->foreign('contest_valuation_id')->references('id')->on('contest_valuations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('judge_id')->references('id')->on('judges')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_contest_scores');
    }
}
