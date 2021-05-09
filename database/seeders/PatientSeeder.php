<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'email' => 'patient@email.com',
            'name' => 'James Cameroon',
            'dob' => '12/12/2020',
            'gender' => 'male',

        ];

        $user = User::create([
            'email' => $data['email'],
            'password' => bcrypt('password')
        ]);
        $user->assignRole('patient');
        $admin = Patient::create($data);
        $admin->update(['user_id' => $user->id]);
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
                'marital_status' => $faker->boolean(50)
            ];
            $user = User::create([
                'email' => $data['email'],
                'password' => bcrypt('password')
            ]);
            $user->assignRole('patient');
            $admin = Patient::create($data);
            $admin->update(['user_id' => $user->id]);
        }
    }
}
