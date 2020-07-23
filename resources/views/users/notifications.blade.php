@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h1>Notifications</h1></div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach($notifications as $notification)
                                @if($notification->type === "App\Notifications\NewReplyAdded")
                                    <li class="list-group-item">
                                    A new reply was posted in your question <strong>{{ $notification->data['question']['title'] }}</strong>
                                    <a href="{{ route('questions.show', $notification->data['question']['slug']) }}" class="float-right btn btn-sm btn-info text-white">View Question</a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
