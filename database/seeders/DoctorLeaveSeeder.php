<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Doctor;
use App\Models\DoctorLeave;

class DoctorLeaveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $doctors = Doctor::all();
        foreach ($doctors as $doctor) {
            for ($i = 0; $i < 5; $i++) {
                $date = $faker->dateTimeBetween(now(), '1year');
                $data = [
                    'doctor_id' => $doctor->id,
                    'date' => $date->format('Y-m-d'),
                ];
                DoctorLeave::create($data);
            }
        }
    }
}
