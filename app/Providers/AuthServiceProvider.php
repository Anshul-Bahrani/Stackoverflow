<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        'App\Question' => 'App\Policies\QuestionPolicy',
        'App\Answer' => 'App\Policies\AnswerPolicy',
        //second method but this requires importss..
        // Question::class => QuestionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
        // $user is default and is passed by gate itself when called, second onwards are user requirements.
        Gate::define('update-question', function($user, $question) {
            return $user->id === $question->user_id;
        });
        Gate::define('delete-question', function($user, $question) {
            return $user->id === $question->user_id && $question->answers_count === 0;
        });
    }
}
