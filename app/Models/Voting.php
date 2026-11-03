<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voting extends Model
{
    protected $fillable = [
        'siswa_id',
        'kandidat_id',
        'waktu',
    ];

    protected $table = 'votings';

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function kandidat()
    {
        return $this->belongsTo(Kandidat::class);
    }
}

