<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Participation extends Model
{
    use HasFactory;
    protected $fillable = ['formation_id', 'personne_id'];

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    public function personne()
    {
        return $this->belongsTo(Personne::class);
    }
}