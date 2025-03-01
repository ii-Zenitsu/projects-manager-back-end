<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *     schema="Projet",
 *     type="object",
 *     title="Projet",
 *     description="Modèle de données pour un projet",
 *     required={"intitule", "dateDebut", "dateFin", "duree"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="intitule", type="string", example="Project A"),
 *     @OA\Property(property="dateDebut", type="string", format="date", example="2024-01-01"),
 *     @OA\Property(property="dateFin", type="string", format="date", example="2024-06-30"),
 *     @OA\Property(property="duree", type="integer", example=180)
 * )
 */


class Projet extends Model
{
    use HasFactory;

    protected $fillable = ['intitule', 'dateDebut', 'dateFin', 'duree'];

    public function personnes()
    {
        return $this->belongsToMany(Personne::class, 'affectations', 'projet_id', 'personne_id');
    }

    public function getStatus()
{
    $today = now();
    $startDate = $this->dateDebut;
    $endDate = $this->dateFin;
    $duration = $this->duree;

    $expectedEndDate = $startDate->copy()->addDays($duration);

    if (!$endDate) {
        return $today->greaterThan($expectedEndDate) ? "Late" : "Ongoing";
    }

    if ($endDate->greaterThan($expectedEndDate)) {
        return "Closed with Late";
    }

    return "Closed";
}

}
