<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['body', 'user_id'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getBodyHtmlAttribute()
    {
        return \Parsedown::instance()->text($this->body);
    }

    public static function boot()
    {
        parent::boot();

        static::created(function($answer){
            $answer->question->increment('answers_count');
            // echo "Answer created\n";
        });

        static::deleted(function($answer){
            $ans_quest = $answer->question;
            $ans_quest->decrement('answers_count');
            /*
            if($ans_quest->best_answer_id === $answer->id){
                $ans_quest->best_answer_id = null;
                $ans_quest->save();
            }
            */
            // $answer->question->decrement('answers_count'); // or down
            // $answer->question->answers_count = $answer->question->answers_count - 1;
            // $answer->question->save();
        });

        // static::saved(function($answer){
        //    echo "Answer saved\n";
        // });
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute()
    {
        return $this->id === $this->question->best_answer_id ? 'vote-accepted' : '';
    }
}
