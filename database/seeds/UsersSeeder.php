<?php

use App\Roles;
use App\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $roles = Roles::where('name', '=', 'Admin')->first();
        $users = User::create([
            'votantes_id' => 1,
            'roles_id' => $roles->id,
            'name' => 'admin',
            'email' => 'admin',
            'password' => bcrypt('admin2020'),
        ]);
    }
}
