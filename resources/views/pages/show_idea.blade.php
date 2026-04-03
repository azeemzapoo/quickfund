this is where i will show the idea details

<h1>{{ $idea->title }}</h1>
<p>{{ $idea->description }}</p>
<p>Funding Goal: {{ $idea->funding_goal }}</p>
<p>Current Amount: {{ $idea->current_amount }}</p>
<p> By: {{ $idea->user->name }}</p>
<a href="/ideas">Back to Ideas</a> 