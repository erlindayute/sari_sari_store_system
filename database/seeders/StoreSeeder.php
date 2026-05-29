<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first user (created in DatabaseSeeder)
        $user = User::first();

        if ($user) {
            Store::create([
                'user_id' => $user->id,
                'store_name' => 'Demo Sari-Sari Store',
                'city' => 'Padova',
                'province' => 'Veneto',
                'country' => 'Italy',
                'code' => 'DEMO-001',
            ]);
        }
    }
}
