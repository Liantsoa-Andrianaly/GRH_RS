<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Affectation extends Model
{
    protected $fillable = [
        'employee_id',
        'poste_ancien_id',
        'poste_nouveau_id',
        'agence_ancien_id',
        'agence_nouveau_id',
        'user_id',
        'date_creation',
    ];

    public $timestamps = false;

    // Relations
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function posteAncien()
    {
        return $this->belongsTo(Poste::class, 'poste_ancien_id');
    }

    public function posteNouveau()
    {
        return $this->belongsTo(Poste::class, 'poste_nouveau_id');
    }

    public function agenceAncien()
    {
        return $this->belongsTo(Agence::class, 'agence_ancien_id');
    }
    public function agenceNouveau()
    {
        return $this->belongsTo(Agence::class, 'agence_nouveau_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
