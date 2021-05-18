<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\Checkup;
use Faker\Factory as Faker;


class CheckupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $appointments = Appointment::all();
        foreach ($appointments as $appointment) {
            $data = [
                'appointment_id' => $appointment->id,
                'date' => $appointment->schedule->date,
                'checkup_info' => $faker->realText(500),
                'prescriptions' => $faker->realText(500)
            ];
            Checkup::create($data);
        }
    }
}
