<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'email' => 'doctor@email.com',
            'name' => 'Doctor. Sarah Williams',
            'dob' => '12/12/2020',
            'gender' => 'male',

        ];

        $user = User::create([
            'email' => $data['email'],
            'password' => bcrypt('password')
        ]);
        $user->assignRole('doctor');
        $admin = Doctor::create($data);
        $admin->update(['user_id' => $user->id]);
    }
}
