<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Play_list;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //admin
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
            'admin'=>true,
            'super_user'=>true,
            'dashboard_control'=>true,
            'chanels_control'=>true,
            'support_control'=>true,
            'comments_control'=>true,
            'videos_control'=>true,
        ]);
        
    }
}
