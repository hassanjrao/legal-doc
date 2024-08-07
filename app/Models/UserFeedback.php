<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserFeedback extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded=[];

    protected $table = 'user_feedbacks';

    public function choice()
    {
        return $this->belongsTo(FeedbackQuestionChoice::class, 'feedback_question_choice_id');
    }

    public function question()
    {
        return $this->belongsTo(FeedbackQuestion::class, 'feedback_question_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
