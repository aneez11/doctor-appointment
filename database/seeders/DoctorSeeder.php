<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\User;
use Faker\Factory as Faker;
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
        $doctor = Doctor::create($data);
        $doctor->update(['user_id' => $user->id]);
        $faker = Faker::create();
        for ($i = 0; $i < 10; $i++) {
            $data = [
                'photo' => $faker->imageUrl(250, 250),
                'name' => $faker->name,
                'email' => $faker->email,
                'phone' => $faker->phoneNumber,
                'dob' => $faker->date(),
                'gender' => 'male',
                'address' => $faker->address,
                'qualification' => $faker->text(50),
                'specialist' => $faker->text(50),
                'fees' => $faker->numberBetween(50, 100)
            ];
            $user = User::create([
                'email' => $data['email'],
                'password' => bcrypt('password')
            ]);
            $user->assignRole('doctor');
            $doctor = Doctor::create($data);
            $doctor->update(['user_id' => $user->id]);
        }
    }
}
