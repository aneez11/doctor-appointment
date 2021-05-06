<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\Report;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
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
            for ($i=0;$i<5;$i++){
                $data = [
                    'patient_id' => $patient->id,
                    'name' => $faker->realText(10),
                    'description' => $faker->realText(500),
                    'image' => $faker->imageUrl(300,400)
                ];
                Report::create($data);
            }
        }
    }
}
