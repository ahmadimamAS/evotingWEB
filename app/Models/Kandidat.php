<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kandidat extends Model
{
    protected $fillable = [
        'nama',
        'kelas',
        'visi',
        'misi',
        'foto',
        'no_urut',
    ];

    public function votings()
    {
        return $this->hasMany(Voting::class);
    }
}

