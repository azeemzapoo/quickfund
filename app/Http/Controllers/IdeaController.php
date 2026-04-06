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

        $request->validate([
                'title'=> 'required|max:255',
                'description'=> 'required',
                'funding_goal'=> 'required|numeric|min:1'            
                ]) ;

        Idea::create([
            'title' => $request->title,
            'description' => $request->description,
            'funding_goal' => $request->funding_goal,
            'user_id' => 1,
            'current_amount' => 0,

        ]);
        return redirect('/')->with('success','Idea Created Successfully!');
    }


    public function edit($id){ 
        $idea = Idea::findOrFail($id);
        return view('pages.edit_idea', compact('idea'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'funding_goal' => 'required|numeric|min:1'
        ]);
    
        $idea = Idea::findOrFail($id);
    
        $idea->update([
            'title' => $request->title,
            'description' => $request->description,
            'funding_goal' => $request->funding_goal
        ]);
    
        return redirect('/')->with('success', 'Idea updated successfully!');
    }


    public function destroy($id)
        {
            $idea = Idea::findOrFail($id);

            $idea->delete();

            return redirect('/')->with('success', 'Idea deleted successfully!');
        }
    
}
