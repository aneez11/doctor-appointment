<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'email' => 'admin@email.com',
            'name' => 'Admin. John Doe',
            'dob' => '12/12/2020',
            'gender' => 'male',

        ];

        $user = User::create([
            'email' => $data['email'],
            'password' => bcrypt('password')
        ]);
        $user->assignRole('admin');
        $admin = Admin::create($data);
        $admin->update(['user_id' => $user->id]);
    }
}
