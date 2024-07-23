<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserFeedback extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded=[];

    public function choice()
    {
        return $this->belongsTo(FeedbackQuestionChoice::class);
    }

    public function question()
    {
        return $this->belongsTo(FeedbackQuestion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
