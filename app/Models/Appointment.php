<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    public function schedule()
    {
        return $this->belongsTo(DoctorSchedule::class, 'doctor_schedule_id');
    }
    public function checkups()
    {
        return $this->hasMany(Checkup::class);
    }
    public function referredTo()
    {
        return $this->belongsTo(Appointment::class, 'referred_to');
    }
    public function referredFrom()
    {
        return $this->belongsTo(Appointment::class, 'referred_from');
    }
    public function payment(){
        return $this->hasOne(Payment::class);
    }
}
