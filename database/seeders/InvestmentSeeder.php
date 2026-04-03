<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Investment;
use App\Models\User;
use App\Models\idea;


class InvestmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //seed some test data for investments

        $user = User::first();
        $idea = idea::first();

    Investment::create([
        'amount' => 100,
        'user_id' => $user->id,
        'idea_id' => $idea->id,
    ]);
    
    Investment::create([
        'amount' => 200,
        'user_id' => $user->id,
        'idea_id' => $idea->id,
    ]);
    
    }
}
