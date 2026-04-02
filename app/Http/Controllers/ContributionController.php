<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\contribution;
use App\Models\idea;
use App\Models\user;   

class ContributionController extends Controller
{
    //


    public function index(){
        $contributions = contribution::all();
        return view('pages.contributions', compact('contributions'));
    }

    public function store(Request $request){
        Contribution::create([
            'role' => $request->role,
            'user_id' => $request->user_id,
            'idea_id' => $request->idea_id,
        ]);
        return redirect('/contributions');
    }
}
