This is the create idea page

<h1>Create Idea</h1>

<form method="POST" action="/ideas">
    @csrf

    <div>
        <label>Title</label>
        <input type="text" name="title">
    </div>

    <div>
        <label>Description</label>
        <textarea name="description"></textarea>
    </div>

    <div>
        <label>Funding Goal</label>
        <input type="number" name="funding_goal">
    </div>

    <button type="submit">Create Idea</button>
</form>