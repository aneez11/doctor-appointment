<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Payment;
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
                $doctor = Doctor::inRandomOrder()->first();

                    $schedule = $doctor->schedules()->first();

                        $appointmentNumber = sprintf("%03u-%s-%s", $doctor->id, $schedule->date, '10:30');
                        $data = [
                            'patient_id' => $patient->id,
                            'doctor_id' => $doctor->id,
                            'doctor_schedule_id' => $schedule->id,
                            'appointment_number' => $appointmentNumber,
                            'reason' => $faker->realText(200),
                            'time' => $faker->time('H:i'),
                            'status' => $faker->randomElement([0]),
                            'type' => $faker->randomElement(['Video','In Person']),
                            'isPaid' => $faker->boolean(50)
                        ];
                        $app = Appointment::create($data);
                        if ($app->type == 'Video'){
                            $app->update(['meeting_link'=>'http://meeting.url']);
                        }
                        if ($app->isPaid == true){
                            Payment::create([
                                'appointment_id' => $app->id,
                                'amount' => $app->doctor->fees
                            ]);
                        }

                }

                // dd($schedule->id);


        }

}
