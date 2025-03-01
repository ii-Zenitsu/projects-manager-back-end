<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    use HasFactory;
    protected $fillable = ['intitule', 'date_debut', 'date_fin', 'lieu', 'nbr_place'];

    public function participations()
    {
        return $this->hasMany(Participation::class);
    }
}