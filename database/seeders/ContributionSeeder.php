<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contribution;
use App\Models\Idea;
use App\Models\User;

class ContributionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //seed some test data for contributions

        $user = User::first();
        $idea = Idea::first();

    Contribution::create([
        'role' => 'Research',
        'user_id' => $user->id,
        'idea_id' => $idea->id,
    ]);

    Contribution::create([
        'role' => 'Developer',
        'user_id' => $user->id,
        'idea_id' => $idea->id,
    ]);
    }
}
