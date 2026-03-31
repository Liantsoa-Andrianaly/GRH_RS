<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class EmployeBackup extends Model
{
    use HasFactory , SoftDeletes;

    // Définir explicitement le nom de la table si différent du nom par défaut
    protected $table = 'employe_backups';

    // Les colonnes que l'on peut remplir via mass-assignment
    protected $fillable = [
        'nom',
        'prenom',
        'sexe',
        'email',
        'adresse',
        'telephone',
        'poste',
        'diplome',
        'date_naissance',
        'lieu_naissance',
        'deleted_at'
    ];

      protected $dates = ['deleted_at'];

   // Date de naissance formatée
    public function getDateNaissanceFormattedAttribute()
    {
        return $this->date_naissance 
            ? Carbon::parse($this->date_naissance)->format('d/m/Y')
            : 'Non défini';
    }

    // Date de suppression formatée
    public function getDeletedAtFormattedAttribute()
    {
        return $this->deleted_at 
            ? Carbon::parse($this->deleted_at)->format('d/m/Y')
            : 'Non défini';
    }
}
