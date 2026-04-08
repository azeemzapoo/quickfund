
<h1>Edit Idea</h1>

<form method="POST" action="/ideas/{{ $idea->id }}">
    @csrf
    @method('PUT')

    <div>
        <label>Title</label>
        <input type="text" name="title" value="{{ $idea->title }}">
    </div>

    <div>
        <label>Description</label>
        <textarea name="description">{{ $idea->description }}</textarea>
    </div>

    <div>
        <label>Funding Goal</label>
        <input type="number" name="funding_goal" value="{{ $idea->funding_goal }}">
    </div>

    <button type="submit">Update Idea</button>
</form>