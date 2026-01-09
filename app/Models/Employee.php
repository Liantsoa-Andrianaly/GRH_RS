<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
    'matricule',
    'nom',
    'prenom',
    'sexe',
    'statut_matrimonial',
    'email',
    'telephone',
    'adresse',
    'diplome',
    'poste_id',
    'agence_id',
    'cin',
    'permis_de_conduire',
    'nationalite',
    'status',
    'date_embauche',
    'salaire_base',
    'photo',
    'solde_conge',
];



    protected $casts = [
        'permis_de_conduire' => 'boolean',
        'date_embauche' => 'date',
        'date_de_naissance' => 'date',
        'salaire_base' => 'decimal:2',
    ];

    /* ================= RELATIONS ================= */

    public function poste()
    {
        return $this->belongsTo(Poste::class);
    }

    public function agence()
    {
        return $this->belongsTo(Agence::class);
    }

    public function conges()
    {
        return $this->hasMany(Conge::class);
    }

    /* ================= ACCESSOR ================= */

    public function getSoldeCongesRestantAttribute()
    {
        $soldePris = $this->conges()
            ->where('statut', 'valide')
            ->sum('nombre');

        return ($this->solde_conge ?? 0) - $soldePris;
    }
}
