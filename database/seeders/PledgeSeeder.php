<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Idea;
use App\Models\Pledge;
use App\Models\User;



class PledgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //seed some test data for pledges

        $user = User::first();
        $idea = Idea::first();


    Pledge::create([
        'amount' => 100,
        'user_id' => $user->id,
        'idea_id' => $idea->id,
    ]);

    Pledge::create([
        'amount' => 200,
        'user_id' => $user->id,
        'idea_id' => $idea->id,
    ]);

    }
}
