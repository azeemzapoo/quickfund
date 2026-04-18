<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;

class IdeaController extends Controller
{
    public function index()
    {
        $ideas = Idea::with('user')
            ->withCount(['pledges', 'contributions', 'investments'])
            ->latest()
            ->get();

        return view('pages.ideas', compact('ideas'));
    }

    public function create()
    {
        return view('pages.create_idea');
    }

    public function show($id)
    {
        $idea = Idea::with('user')
            ->with(['contributions.user'])
            ->withCount(['pledges', 'contributions', 'investments'])
            ->findOrFail($id);

        return view('pages.show_idea', compact('idea'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'funding_goal' => 'required|numeric|min:1',
        ]);

        $idea = Idea::create([
            'title' => $request->title,
            'description' => $request->description,
            'funding_goal' => $request->funding_goal,
            'user_id' => auth()->id(),
            'current_amount' => 0,
        ]);

        return redirect()->route('ideas.show', $idea->id)->with('success', 'Idea Created Successfully!');
    }

    public function edit($id)
    {
        $idea = Idea::findOrFail($id);

        if ($idea->user_id !== auth()->id()) {
            abort(403, 'You are not authorized to edit this idea.');
        }

        return view('pages.edit_idea', compact('idea'));
    }

    public function update(Request $request, $id)
    {
        $idea = Idea::findOrFail($id);

        if ($idea->user_id !== auth()->id()) {
            abort(403, 'You are not authorized to update this idea.');
        }

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'funding_goal' => 'required|numeric|gte:' . $idea->current_amount,
        ]);

        $idea->update([
            'title' => $request->title,
            'description' => $request->description,
            'funding_goal' => $request->funding_goal,
        ]);

        return redirect()->route('ideas.show', $idea->id)->with('success', 'Idea updated successfully!');
    }

    public function destroy($id)
    {
        $idea = Idea::findOrFail($id);

        if ($idea->user_id !== auth()->id()) {
            abort(403, 'You are not authorized to delete this idea.');
        }

        $idea->delete();

        return redirect()->route('ideas.index')->with('success', 'Idea deleted successfully!');
    }
}
