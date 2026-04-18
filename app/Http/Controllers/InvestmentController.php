<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\Investment;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    public function index()
    {
        $investments = Investment::with(['user', 'idea'])->latest()->get();

        return view('pages.investments', compact('investments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validateWithBag('investment', [
            'amount' => ['required', 'numeric', 'min:1'],
            'idea_id' => ['required', 'integer', 'exists:ideas,id'],
        ]);

        $idea = Idea::findOrFail($validated['idea_id']);
        $remainingAmount = max(0, (int) $idea->funding_goal - (int) $idea->current_amount);

        if ($idea->user_id === auth()->id()) {
            return redirect()
                ->route('ideas.show', $idea->id)
                ->with('investment_error', 'You cannot invest in your own idea.');
        }

        if ($remainingAmount <= 0) {
            return redirect()
                ->route('ideas.show', $idea->id)
                ->with('investment_error', 'This idea has already reached its funding goal.');
        }

        if ((int) $validated['amount'] > $remainingAmount) {
            return redirect()
                ->route('ideas.show', $idea->id)
                ->withInput()
                ->with('investment_error', 'Investment amount cannot be more than the remaining goal amount of $' . number_format($remainingAmount) . '.');
        }

        Investment::create([
            'amount' => $validated['amount'],
            'user_id' => auth()->id(),
            'idea_id' => $idea->id,
        ]);

        $idea->current_amount += (int) $validated['amount'];
        $idea->save();

        return redirect()
            ->route('ideas.show', $idea->id)
            ->with('investment_success', 'Your investment was added successfully.');
    }
}
