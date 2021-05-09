<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Faker\Factory as Faker;

use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $patients = Patient::all();
        foreach ($patients as $patient) {
            for ($i = 0; $i < 5; $i++) {
                $doctor = Doctor::inRandomOrder()->first();
                $schedule = $doctor->schedules->first();
                $data = [
                    'patient_id' => $patient->id,
                    'doctor_id' => $doctor->id,
                    'doctor_schedule_id' => $schedule->id,
                    'appointment_number' => $faker->creditCardNumber(),
                    'reason' => $faker->realText(200),
                    'time' => $faker->time('H:i'),
                    'status' => $faker->boolean(50)
                ];
                Appointment::create($data);
            }
        }
    }
}
