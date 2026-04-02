<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PledgeController extends Controller
{
    //


    public function index(){
        $pledges = pledge::all();
        return view('pages.pledges', compact('pledges'));
    }

    public function store(Request $request){
        Pledge::create([
            'amount' => $request->amount,
            'user_id' => $request->user_id,
            'idea_id' => $request->idea_id,
        ]);
        $idea->current_amount += $request->amount;
        $idea->save();
        return redirect('/pledges');
    }
}
