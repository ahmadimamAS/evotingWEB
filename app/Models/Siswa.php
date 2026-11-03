<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Authenticatable
{
    protected $fillable = [
        'nik',
        'nama',
        'kelas',
        'password',
        'status_memilih',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $table = 'siswas';

    public function votings()
    {
        return $this->hasMany(Voting::class);
    }
}

