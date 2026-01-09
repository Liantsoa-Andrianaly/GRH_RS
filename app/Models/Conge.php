<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conge extends Model
{
    protected $fillable = [
        'employee_id',
        'date_debut',
        'date_fin',
        'type',
        'motif',
        'statut',
        'commentaire_validation',
        'nombre',
       
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($conge) {
            $employee = $conge->employee;
            $conge->solde_restant = $employee->solde_conge - $conge->jours;
        });
    }
}
