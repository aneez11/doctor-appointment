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
                if ($doctor) {
                    $schedule = $doctor->schedules()->first();
                    if ($schedule) {
                        $appointmentNumber = sprintf("%03u-%s-%s", $doctor->id, $schedule->date, '10:30');
                        $data = [
                            'patient_id' => $patient->id,
                            'doctor_id' => $doctor->id,
                            'doctor_schedule_id' => $schedule->id,
                            'appointment_number' => $appointmentNumber,
                            'reason' => $faker->realText(200),
                            'time' => $faker->time('H:i'),
                            'status' => $faker->randomElement([0])
                        ];
                        Appointment::create($data);
                    }
                }

                // dd($schedule->id);

            }
        }
    }
}
