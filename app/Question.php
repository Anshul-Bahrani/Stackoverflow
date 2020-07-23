<?php

namespace App;
use App\User;
use App\Answer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Question extends Model
{
    protected $guarded = [];

    public function setTitleAttribute($title) {
    	$this->attributes['title'] = $title;
    	$this->attributes['slug'] = Str::slug($title);
    }

/*
* RelationShip Methods..
*/
    public function author() {
    	return $this->belongsTo(User::class, 'user_id');
    }

/*
* ACCESSORS: these methods have a getXXXAtrribute format used to call attributes directly from an object.
*/
    public function getUrlAttribute() {
        return "questions/{$this->slug}";
    }

    public function getCreatedDateAttribute() {
        return $this->created_at->diffForHumans();
    }

    public function getAnswersStyleAttribute() {
        if($this->answers_count > 0) {
            if($this->best_answer_id) {
                return "has-best-answer";
            }
            return "answered";
        }
        return "unanswered";
    }

    public function getFavoritiesCountAttribute() {
        return $this->favorities()->count();
    }
    public function getIsFavoriteAttribute() {
        return $this->favorities()->where(['user_id' => auth()->id()])->count() > 0;
    }

    public function answers() {
        return $this->hasMany(Answer::class);
    }
    public function favorities() {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
    /**
     * HELPER FUNCTIONS
     */
    public function markBestAnswer(Answer $answer) {
        $this->best_answer_id = $answer->id;
        $this->save();
    }
    public function votes() {
        return $this->morphToMany(User::class, 'vote')->withTimestamps();
    }

    public function vote(int $vote) {
        if($vote < 0) {
            $this->decrement('votes_count');
        }
        else {
            $this->increment('votes_count');
        }
    }
    public function updateVote(int $vote) {
        $this->votes()->updateExistingPivot(auth()->id(), ['vote' =>$vote]);
    if($vote < 0) {
        $this->decrement('votes_count');
        $this->decrement('votes_count');
    }
    else {
        $this->increment('votes_count');
        $this->increment('votes_count');
    }

    }

}
