<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Question;
use App\User;


class Answer extends Model
{
    protected $guarded =[];

    public static function boot() {
        parent::boot();

        static::created(function($answer) {
            $answer->question->increment('answers_count');
        });
        static::deleted(function($answer) {
            $answer->question->decrement('answers_count');
        });
    }

    public function getCreatedDateAttribute() {
        return $this->created_at->diffForHumans();
    }
    public function getbestAnswerStatusAttribute() {
        if($this->id === $this->question->best_answer_id) {
            return "text-success";
        }
        return "text-dark";
    }
    public function getisBestAttribute() {
        return $this->id === $this->question->best_answer_id;
    }
    /*
     * RELATIOSHIP METHODS
     */

    public function question() {
        return $this->belongsTo(Question::class);
    }
    public function author() {
        return $this->belongsTo(User::class, 'user_id');
    }

}
