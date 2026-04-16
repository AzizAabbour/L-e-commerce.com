<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Add categories
        $categories = ['Electronics', 'Clothing', 'Home & Garden', 'Books'];
        foreach ($categories as $cat) {
            \App\Models\Categorie::create(['nom_categorie' => $cat]);
        }

        // Create Admin
        \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'admin',
            'address' => 'Admin HQ',
            'phone' => '0600000000'
        ]);

        // Create Client
        \App\Models\User::create([
            'name' => 'John Doe',
            'email' => 'client@client.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'client',
            'address' => '123 Main St',
            'phone' => '0611111111'
        ]);
    }
}
