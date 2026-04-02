<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IdeaController extends Controller
{
    //


    public function index(){
        $ideas = idea::all();
        return view('pages.ideas', compact('ideas'));
    }


    public function create(){
        return view('pages.create_idea');
    }


    public function store(Request $request)
    {
        idea::create([
            'title' => $request->title,
            'description' => $request->description,
            'funding_goal' => $request->funding_goal,
            'current_amount' => 0,
            'user_id' => 1 // temporary
        ]);

        return redirect('/ideas');
    }


    public function show($id){
        $idea = idea::find($id);
        return view('pages.show_idea', compact('idea'));
    }
    
    
}
