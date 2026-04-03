<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\idea;

class IdeaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * 
     */
    public function run(): void
    {

        // lets seed some test data

        idea::create([
            'title' => 'Campus Food App',
            'description' => 'An app for students to order affordable meals on campus',
            'funding_goal' => 500,
            'current_amount' => 100,
            'user_id' => 1
        ]);
    
        idea::create([
            'title' => 'Student Marketplace',
            'description' => 'Platform for students to buy and sell used items',
            'funding_goal' => 800,
            'current_amount' => 250,
            'user_id' => 1
        ]);
    
        idea::create([
            'title' => 'Study Buddy Finder',
            'description' => 'Find study partners based on courses and availability',
            'funding_goal' => 300,
            'current_amount' => 50,
            'user_id' => 1
        ]);
    }
}
