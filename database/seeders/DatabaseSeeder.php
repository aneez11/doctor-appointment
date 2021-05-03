<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            AdminSeeder::class,
            DoctorSeeder::class,
            PatientSeeder::class,
            AppointmentSeeder::class,
            DoctorScheduleSeeder::class
        ]);
    }
}
