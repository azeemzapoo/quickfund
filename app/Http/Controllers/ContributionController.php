<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Models\Idea;
use Illuminate\Http\Request;

class ContributionController extends Controller
{
    public function index()
    {
        $contributions = Contribution::with(['user', 'idea'])->latest()->get();

        return view('pages.contributions', compact('contributions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validateWithBag('contribution', [
            'role' => ['required', 'string', 'in:Developer,Designer,Marketing,Research'],
            'idea_id' => ['required', 'integer', 'exists:ideas,id'],
        ]);

        $idea = Idea::findOrFail($validated['idea_id']);

        if ($idea->user_id === auth()->id()) {
            return redirect()
                ->route('ideas.show', $idea->id)
                ->with('contribution_error', 'You cannot join your own idea as a contributor.');
        }

        $alreadyJoined = Contribution::where('idea_id', $idea->id)
            ->where('user_id', auth()->id())
            ->exists();

        if ($alreadyJoined) {
            return redirect()
                ->route('ideas.show', $idea->id)
                ->with('contribution_error', 'You have already joined this idea as a contributor.');
        }

        Contribution::create([
            'role' => $validated['role'],
            'user_id' => auth()->id(),
            'idea_id' => $idea->id,
        ]);

        return redirect()
            ->route('ideas.show', $idea->id)
            ->with('contribution_success', 'You joined this idea as a contributor.');
    }
}
