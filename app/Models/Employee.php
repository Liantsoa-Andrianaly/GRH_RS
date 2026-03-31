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
        
        'solde_conge',
        'date_naissance',
        'lieu_naissance'
    ];

    protected $casts = [
        'permis_de_conduire' => 'boolean',
        'date_embauche' => 'date',   
        'date_naissance' => 'date',
        'salaire_base' => 'decimal:2',
    ];

     protected $dates = ['deleted_at'];

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

    /* ================= ACCESSORS ================= */

    // Solde de congé restant
    public function getSoldeCongesRestantAttribute()
    {
        $soldePris = $this->conges()
            ->where('statut', 'valide')
            ->sum('nombre');

        return ($this->solde_conge ?? 0) - $soldePris;
    }

    // Permis de conduire : 1 => "Rien"
    public function getPermisDeConduireAfficheAttribute()
    {
        return $this->permis_de_conduire ? 'Rien' : '-';
    }

    // Salaire de base : null => 0
    public function getSalaireBaseAfficheAttribute()
    {
        return $this->salaire_base ?? 0;
    }

   
    /* ================= ACCESSORS ================= */

      

        public function getPermisAfficheAttribute()
        {
            // Si le permis vaut 1, afficher "Rien", sinon la valeur ou "-"
            return $this->permis_de_conduire === 1 ? 'Rien' : ($this->permis_de_conduire ?? '-');
        }

        public function getDateNaissanceFormatteAttribute()
        {
            return $this->date_naissance ? $this->date_naissance->format('d/m/Y') : '-';
        }

        public function getDateEmbaucheFormatteAttribute()
        {
            return $this->date_embauche ? $this->date_embauche->format('d/m/Y') : '-';
        }

        public function getSalaireAfficheAttribute()
        {
            return $this->salaire_base ?? 0;
        }
}