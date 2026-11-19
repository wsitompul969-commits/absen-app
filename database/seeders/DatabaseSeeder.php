<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            ['name' => 'Admin', 'password' => Hash::make('admin123'), 'role' => 'admin'],
        );

        User::firstOrCreate(
            ['email' => 'staff@absensi.com'],
            ['name' => 'Staff', 'password' => Hash::make('staff123'), 'role' => 'staff'],
        );

        $this->call(DepartemenTeamSeeder::class);
        $this->call(AbsensiSeeder::class);
    }
}
