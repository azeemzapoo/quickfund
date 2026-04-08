@extends('layouts.app')

@section('content')




<h1>Create Idea</h1>


@if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="/ideas">
    @csrf

    <div>
        <label>Title</label>
        <input type="text" name="title" value="{{ old('title') }}">
    </div>

    <div>
        <label>Description</label>
        <textarea name="description">{{ old('description') }}</textarea>
    </div>

    <div>
        <label>Funding Goal</label>
        <input type="number" name="funding_goal" value = "{{ old('funding_goal') }}">
    </div>

    <button type="submit">Create Idea</button>
</form>

@endsection