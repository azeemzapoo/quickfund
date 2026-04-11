<?php

namespace App\Http\Controllers;

use App\Models\investment;
use App\Models\idea;
use App\Models\user;   
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    //
public function store(Request $request, $id)
{
    $idea = Idea::findOrFail($id);

    return Investment::create([
        'amount' => $request->amount,
        'user_id' => auth()->id(),
        'idea_id' => $idea->id
    ]);
}

}
