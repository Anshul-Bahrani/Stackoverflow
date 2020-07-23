<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Question;
use App\Answer;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAvatarAttribute() {
        $size = 40;
        $name = $this->name;
        return "https://ui-avatars.com/api/?name={$name}&rounded=true&size={$size}";
    }


    public function questions() {
        return $this->hasMany(Question::class);
    }
    public function answers() {
        return $this->hasMany(Answer::class);
    }
    public function favorities() {
        return $this->belongsToMany(Question::class)->withTimestamps();
    }

    public function votesQuestions() {
        // dd($this->morphedByMany(Question::class, 'vote')->withTimestamps());
        return $this->morphedByMany(Question::class, 'vote')->withTimestamps();
    }
    public function votesAnswers() {
        // dd($this->morphedByMany(Answer::class, 'vote')->withTimestamps());
        return $this->morphedByMany(Answer::class, 'vote')->withTimestamps();
    }

    public function hasQuestionUpVote(Question $question) {
        return auth()->user()->votesQuestions()->where(['vote' => 1, 'vote_id' =>$question->id])->exists();

    }
    public function hasQuestionDownVote(Question $question) {
        return auth()->user()->votesQuestions()->where(['vote' => -1, 'vote_id' =>$question->id])->exists();

    }
    public function hasVoteForQuestion(Question $question) {
        // dd($this->hasQuestionUpVote($question) || $this->hasQuestionDownVote($question));
        return $this->hasQuestionUpVote($question) || $this->hasQuestionDownVote($question);
    }
    public function hasAnswerUpVote(Answer $answer) {
        return auth()->user()->votesAnswers()->where(['vote' => 1, 'vote_id' =>$answer->id])->exists();

    }
    public function hasAnswerDownVote(Answer $answer) {
        return auth()->user()->votesAnswers()->where(['vote' => -1, 'vote_id' =>$answer->id])->exists();

    }
    public function hasVoteForAnswer(Answer $answer) {
        return $this->hasAnswerUpVote($answer) || $this->hasAnswerDownVote($answer);
    }
}
