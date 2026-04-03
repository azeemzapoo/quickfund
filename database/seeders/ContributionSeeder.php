<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contribution;
use App\Models\User;
use App\Models\idea;

class ContributionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //seed some test data for contributions

        $user = User::first();
        $idea = idea::first();

    Contribution::create([
        'role' => 'investor',
        'user_id' => $user->id,
        'idea_id' => $idea->id,
    ]);

    Contribution::create([
        'role' => 'contributor',
        'user_id' => $user->id,
        'idea_id' => $idea->id,
    ]);
    }
}
