<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Role;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Role::create(['name' => 'driver']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'client']);

        User::create([
            'name' => 'Admin',
            'email' => 'admin123@mail.ca',
            'email_verified_at' => now(),
            'role_id' => '2',
            'address' => '2 Yonge Street',
            'phone_number' => '4161236677',
            'password' => bcrypt('12344321'),
            'created_at' => now(),
        ]);

        User::create([
            'name' => 'Test Driver 1',
            'email' => 'driver123@mail.ca',
            'email_verified_at' => now(),
            'role_id' => '1',
            'address' => '1 Yonge Street',
            'phone_number' => '4161231111',
            'password' => bcrypt('1234'),
            'created_at' => now(),
        ]);

        User::create([
            'name' => 'Test Client',
            'email' => 'client123@mail.ca',
            'email_verified_at' => now(),
            'role_id' => '3',
            'address' => '3 Yonge Street',
            'phone_number' => '4161233333',
            'description' => 'A description of 25 characters.',
            'password' => bcrypt('1234'),
            'created_at' => now(),

        ]);
    }
}
