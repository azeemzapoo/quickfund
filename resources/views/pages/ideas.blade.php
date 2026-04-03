@extends('layouts.app')

@section('content')
    <h1>All Ideas</h1>

    @foreach($ideas as $idea)
        <div>
            <h3>{{ $idea->title }}</h3>
            <p>{{ $idea->description }}</p>
            <p>Funding Goal: {{ $idea->funding_goal }}</p>
            <p>Current Amount: {{ $idea->current_amount }}</p>
            <p> By: {{ $idea->user->name }}</p>
            <a href="/ideas/{{ $idea->id }}">View Idea</a>
        </div>
    @endforeach
@endsection