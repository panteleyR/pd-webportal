<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleAdmin = Role::where('name', 'admin')->first();
        app('db')->table('users')->insert([
            'name' => 'Преподаватель',
            'login' => 'prepod',
            'password' => app('hash')->make('paroltest123'),
            'role_id' => $roleAdmin->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
