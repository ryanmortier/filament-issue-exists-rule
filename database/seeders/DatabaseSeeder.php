<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Collection;
use App\Models\User;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()
            ->has(Collection::factory()->count(5))
            ->create([
                'name' => 'Test User 1',
                'email' => 'test1@example.com',
            ]);

        User::factory()
            ->has(Collection::factory()->count(5))
            ->create([
                'name' => 'Test User 2',
                'email' => 'test2@example.com',
            ]);

        Account::factory()->count(25)->create();
    }
}
