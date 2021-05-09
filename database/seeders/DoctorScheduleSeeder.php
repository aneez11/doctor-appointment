<?php

namespace Database\Seeders;

use App\Models\DoctorSchedule;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

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
        for ($i = 0; $i < 100; $i++) {
            $data = [
                'doctor_id' => $faker->numberBetween(1, 10),
                'date' => $faker->date(),
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
