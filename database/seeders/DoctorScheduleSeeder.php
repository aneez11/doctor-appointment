<?php

namespace Database\Seeders;

use App\Models\DoctorSchedule;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

use App\Models\Doctor;

class DoctorScheduleSeeder extends Seeder
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
                    'day' => $faker->dayOfWeek,
                    'start_time' => '10:00',
                    'end_time' => '17:00',
                    'max_patients' => $faker->numberBetween(5, 15),
                    'status' => $faker->boolean(80)
                ];
                DoctorSchedule::create($data);
            }
        }
    }
}
