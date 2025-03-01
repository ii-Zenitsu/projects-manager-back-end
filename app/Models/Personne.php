<?php

namespace App\Models;

use App\Models\Projet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *     schema="Personne",
 *     type="object",
 *     title="Personne",
 *     description="Modèle de données pour une personne",
 *     required={"id", "nom", "prenom", "email"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nom", type="string", example="Dupont"),
 *     @OA\Property(property="prenom", type="string", example="Jean"),
 *     @OA\Property(property="email", type="string", format="email", example="jean@example.com"),
 *     @OA\Property(property="tele", type="string", example="0612345678"),
 * )
 */



class Personne extends Model
{
    use HasFactory;
    protected $fillable = ['nom', 'prenom', 'email', 'tele'];

    public function participations()
    {
        return $this->hasMany(Participation::class);
    }
    public function projets()
    {
        return $this->belongsToMany(Projet::class, 'affectations', 'personne_id', 'projet_id');
}
}