<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agence extends Model
{
    protected $fillable = [
        'code', 
        'nom', 
        'abreviation',
         'siege',
        'date_creation', 
        'mapping', '
        fokontany_id'
    ];

    public function affectations()
    {
        return $this->hasMany(Affectation::class);
    }
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
