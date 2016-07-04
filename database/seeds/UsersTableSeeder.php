<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    
        \App\Role::create([
            'id' => 0,
            'title' => 'Administrator'
        ]);
        \App\Role::create([
            'id' => 1,
            'title' => 'User'
        ]);

        \App\User::create([
            'name' => 'Admin User 1',
            'email' => 'admin1@admin.com',
            'password' => bcrypt('admin123'),
            'role_id' => 0, 
            'confirmed' => true,
            'admin' => 0,
        ]);
    

        \App\User::create([
            'name' => 'Normal User 1',
            'email' => 'user1@user.com',
            'password' => bcrypt('user123'),
            'role_id' => 1, 
            'confirmed' => false,
            'admin' => 1,
        ]);

        \App\User::create([
            'name' => 'Normal User 2',
            'email' => 'user2@user.com',
            'password' => bcrypt('user123'),
            'role_id' => 1,
            'confirmed' => false,
            'admin' => 1,
        ]);        

        \App\User::create([
            'name' => 'Normal User 3',
            'email' => 'user3@user.com',
            'password' => bcrypt('user123'),
            'role_id' => 1,
            'confirmed' => false,
            'admin' => 1,
        ]);        
    }
}
