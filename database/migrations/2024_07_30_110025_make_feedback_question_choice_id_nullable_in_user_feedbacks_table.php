<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeFeedbackQuestionChoiceIdNullableInUserFeedbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_feedbacks', function (Blueprint $table) {
            $table->unsignedBigInteger('feedback_question_choice_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_feedbacks', function (Blueprint $table) {
            $table->unsignedBigInteger('feedback_question_choice_id')->change();
        });
    }
}
