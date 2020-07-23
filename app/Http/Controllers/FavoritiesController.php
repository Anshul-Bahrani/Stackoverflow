<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
class FavoritiesController extends Controller
{
    public function store(Question $question) {
    	$question->favorities()->attach(auth()->id());
    	return redirect()->back();
    }
    public function destroy(Question $question) {
    	$question->favorities()->detach(auth()->id());
    	return redirect()->back();
    }
}
