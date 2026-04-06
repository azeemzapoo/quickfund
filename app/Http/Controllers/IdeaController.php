<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\idea;
use App\Models\user;
use App\Models\pledge;
use App\Models\contribution;
use App\Models\investment;

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



    public function show($id){
        $idea = idea::find($id);
        return view('pages.show_idea', compact('idea'));
    }

    public function store(Request $request){
        Idea::create([
            'title' => $request->title,
            'description' => $request->description,
            'funding_goal' => $request->funding_goal,
            'user_id' => 1,
            'current_amount' => 0,

        ]);
        return redirect('/ideas');
    }
    
    
}
