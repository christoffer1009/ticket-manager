<?php

namespace Database\Seeders;

use App\Models\Priority;
use App\Models\Role;
use App\Models\Status;
use App\Models\Ticket;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Role::factory()->create([
            'name' => 'admin',
        ]);
        Role::factory()->create([
            'name' => 'technician',
        ]);
        Role::factory()->create([
            'name' => 'client',
        ]);

        Status::factory()->create([
            'name' => 'open'
        ]);
        Status::factory()->create([
            'name' => 'in progress'
        ]);
        Status::factory()->create([
            'name' => 'closed'
        ]);

        Priority::factory()->create([
            'name' => 'low'
        ]);
        Priority::factory()->create([
            'name' => 'medium'
        ]);
        Priority::factory()->create([
            'name' => 'high'
        ]);
        Priority::factory()->create([
            'name' => 'critical'
        ]);

        User::factory(1)->create([
            'name' => 'admin',
            'role_id' => 1,
            'email' => 'admin@localhost',
            'password' => Hash::make('admin'),
        ]);

        Ticket::factory(10)->create();
    }
}
