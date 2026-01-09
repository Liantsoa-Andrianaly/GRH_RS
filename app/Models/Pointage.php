<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pointage extends Model
{
    protected $fillable = [
        'employee_id',
        'entree',
        'sortie',
        'minutes_total',
        'presence',
    ];

    protected $casts = [
        'entree' => 'datetime',
        'sortie' => 'datetime',
    ];

    // Relation vers l'employé
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Calculer le nombre de minutes totales
    public function calculerMinutesTotal()
    {
        if ($this->entree && $this->sortie) {
            $this->minutes_total = $this->sortie->diffInMinutes($this->entree);
        } else {
            $this->minutes_total = 0;
        }
    }

    // Formatage des heures totales (ex : 7h30)
    public function heuresTotalesFormat()
    {
        if ($this->minutes_total) {
            $heures = floor($this->minutes_total / 60);
            $minutesRestantes = $this->minutes_total % 60;
            return "{$heures}h{$minutesRestantes}";
        }
        return "—";
    }
}
