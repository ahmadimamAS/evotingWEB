<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kandidat;
use App\Models\Setting;
use App\Models\Voting;
use Carbon\Carbon;

class HomeController extends Controller
{

    public function welcome()
{
    $manual = Setting::get('voting_aktif', '0') === '1';
    $mulai = Setting::get('voting_mulai') ? Carbon::parse(Setting::get('voting_mulai')) : null;
    $selesai = Setting::get('voting_selesai') ? Carbon::parse(Setting::get('voting_selesai')) : null;
    $now = Carbon::now();

    // Tampilkan hasil jika voting sudah selesai
    $tampilkanHasil = ($mulai && $selesai && $now->greaterThan($selesai));

    $hasilVoting = [];
    $totalSuara = 0;

    if ($tampilkanHasil) {
        $kandidats = Kandidat::orderBy('no_urut')->get();
        $totalSuara = Voting::count();

        foreach ($kandidats as $kandidat) {
            $count = Voting::where('kandidat_id', $kandidat->id)->count();
            $persen = $totalSuara > 0 ? round(($count / $totalSuara) * 100, 1) : 0;

            $hasilVoting[] = [
                'kandidat' => $kandidat,
                'suara' => $count,
                'persen' => $persen,
            ];
        }
    }

    return view('welcome', compact('tampilkanHasil', 'hasilVoting', 'totalSuara'));
}

public function index()
{
    $setting = Setting::first();

    $waktuMulai = $setting->waktu_mulai;
    $waktuSelesai = $setting->waktu_selesai;

    $now = Carbon::now();

    // voting sedang aktif
    $votingAktif = $now >= $waktuMulai && $now <= $waktuSelesai;

    // voting sudah selesai
    $votingSelesai = $now > $waktuSelesai;

    $kandidats = Kandidat::all();

    return view('welcome', compact(
        'votingAktif',
        'votingSelesai',
        'kandidats'
    ));
}

    // Profil OSIS
    public function profil()
    {
        return view('profil');
    }

    // Informasi Pemilihan
    public function informasi()
    {
        $waktuMulai = Setting::get('waktu_mulai', 'Belum dijadwalkan');
        $waktuSelesai = Setting::get('waktu_selesai', 'Belum dijadwalkan');
        $votingAktif = Setting::get('voting_aktif', '0') === '1';
        
        return view('informasi', compact('waktuMulai', 'waktuSelesai', 'votingAktif'));
    }

    // Daftar Kandidat (Public)
    public function daftarKandidat()
    {
        $kandidats = Kandidat::orderBy('no_urut')->get();
        return view('kandidat', compact('kandidats'));
    }
}

