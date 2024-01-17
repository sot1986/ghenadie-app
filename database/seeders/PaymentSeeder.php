<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = \App\Models\User::all(); // connection from User Model

        $users->each(function (\App\Models\User $user) {
            $user->payments()->create([
                'amount' => rand(100, 1000),
            ]); // user_id is automatically set
        });
    }
}
