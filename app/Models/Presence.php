<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    protected $fillable = [
        'employee_id',
        'date_presence',
        'heure_arrivee',
        'heure_depart',
        'statut',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
