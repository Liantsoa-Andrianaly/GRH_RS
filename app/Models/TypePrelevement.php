<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypePrelevement extends Model
{
    use HasFactory;
    protected $table = 'types_prelevements';


    protected $fillable = [
        'nom-complet',
        'abreviation',
        'type_valeur',
        'valeur'
    ];
}

