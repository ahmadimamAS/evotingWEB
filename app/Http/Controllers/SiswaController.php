<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Siswa;
use App\Models\Kandidat;
use App\Models\Voting;
use App\Models\Setting;
use Carbon\Carbon;


class SiswaController extends Controller
{

public function hapusKelas(Request $request)
{
    $request->validate([
    'kelas' => 'required|string'
    ]);
    Siswa::where('kelas', $request->kelas)->delete();

    return back()->with('success', 'Data siswa berdasarkan kelas berhasil dihapus');
}

public function hapusNama(Request $request)
{
    Siswa::where('nama', $request->nama)->delete();

    return back()->with('success', 'Data siswa berdasarkan nama berhasil dihapus');
}

public function hapusSemua()
{
    // Karena ada foreign key dari votings ke siswas, truncate siswas tidak bisa langsung.
    // Hapus data votings dulu, baru hapus siswas.
    Voting::truncate();
    Siswa::truncate();

    return back()->with('success', 'Semua data siswa berhasil dihapus');
}

    // Proses import
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();

        $rows = array_map('str_getcsv', file($path));

        if (count($rows) <= 1) {
            return back()->with('error', 'File kosong atau tidak valid!');
        }

        // Header
        $header = array_map(function ($h) {
            return strtolower(trim($h));
        }, $rows[0]);

        unset($rows[0]);

        $berhasil = 0;
        $gagal = 0;

        foreach ($rows as $index => $row) {

            // Skip baris kosong
            if (count($row) < 4) {
                $gagal++;
                continue;
            }

            $row = array_combine($header, $row);

            // Validasi kolom wajib
            if (
                !isset($row['nik'], $row['nama'], $row['kelas'], $row['password']) ||
                empty($row['nik']) ||
                empty($row['nama'])
            ) {
                $gagal++;
                continue;
            }

            try {
                Siswa::updateOrCreate(
                    ['nik' => trim($row['nik'])],
                    [
                        'nama'     => trim($row['nama']),
                        'kelas'    => trim($row['kelas']),
                        'password' => Hash::make(trim($row['password'])),
                    ]
                );

                $berhasil++;

            } catch (\Exception $e) {
                $gagal++;
            }
        }

        return back()->with('success', "Import selesai. Berhasil: $berhasil, Gagal: $gagal");
    }

    // Dashboard Siswa
    public function dashboard()
    {
        $siswa = Auth::guard('siswa')->user();

        $votingAktif = $this->votingAktif();

        $kandidats = Kandidat::orderBy('no_urut')->get();
        
        $sudahMemilih = Voting::where('siswa_id', $siswa->id)->exists();
        $kandidatDipilih = null;

        if ($sudahMemilih) {
            $voting = Voting::where('siswa_id', $siswa->id)->first();
            if ($voting) {
                $kandidatDipilih = Kandidat::find($voting->kandidat_id);
            }
        }

        return view('siswa.dashboard', compact(
            'siswa',
            'votingAktif',
            'kandidats',
            'sudahMemilih',
            'kandidatDipilih'
        ));
    }

    // Halaman Voting
    public function voting()
    {
        $siswa = Auth::guard('siswa')->user();
        $votingAktif = $this->votingAktif();

        if (Voting::where('siswa_id', $siswa->id)->exists()) {
            return redirect()->route('siswa.dashboard')
                ->with('error', 'Anda sudah melakukan voting');
        }

        if (!$votingAktif) {
            return redirect()->route('siswa.dashboard')
                ->with('error', 'Voting belum dimulai atau sudah ditutup');
        }

        $kandidats = Kandidat::orderBy('no_urut')->get();
        return view('siswa.voting', compact('kandidats'));
    }

    // Proses Voting
    public function votingStore(Request $request)
    {
        $siswa = Auth::guard('siswa')->user();
        $votingAktif = $this->votingAktif();

        $request->validate([
            'kandidat_id' => 'required|exists:kandidats,id',
        ]);

        if (Voting::where('siswa_id', $siswa->id)->exists()) {
            return redirect()->route('siswa.dashboard')
                ->with('error', 'Anda sudah melakukan voting');
        }

        if (!$votingAktif) {
            return redirect()->route('siswa.dashboard')
                ->with('error', 'Voting belum dimulai atau sudah ditutup');
        }

        Voting::create([
            'siswa_id' => $siswa->id,
            'kandidat_id' => $request->kandidat_id,
            'waktu' => now(),
        ]);

        $siswa->update([
            'status_memilih' => true
        ]);

        return redirect()->route('siswa.dashboard')
            ->with('success', 'Terima kasih! Suara Anda berhasil direkam');
    }

    // Status Pemilihan
    public function status()
    {
        $siswa = Auth::guard('siswa')->user();
        $votingAktif = $this->votingAktif();
        $sudahMemilih = Voting::where('siswa_id', $siswa->id)->exists();
        
        $voting = Voting::where('siswa_id', $siswa->id)->first();
        
        return view('siswa.status', compact(
            'siswa',
            'votingAktif',
            'sudahMemilih',
            'voting'
        ));
    }

    // 🔥 TAMBAH SISWA (UNTUK ADMIN)
    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:siswas,nik',
            'nama' => 'required',
            'kelas' => 'required',
            'password' => 'required|min:6',
        ]);

        Siswa::create([
            'nik' => $request->nik,
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'password' => Hash::make($request->password),
            'status_memilih' => false,
        ]);

        return redirect()->back()
            ->with('success', 'Data siswa berhasil ditambahkan');
    }
    

    // 🔑 Fungsi untuk cek voting aktif otomatis
    private function votingAktif()
    {
        $manual = Setting::get('voting_aktif', '0') === '1'; // tombol ON/OFF
        $mulai = Setting::get('voting_mulai') ? Carbon::parse(Setting::get('voting_mulai')) : null;
        $selesai = Setting::get('voting_selesai') ? Carbon::parse(Setting::get('voting_selesai')) : null;
        $now = Carbon::now();

        if (!$manual) {
            return false; // jika tombol OFF, voting tidak aktif
        }

        if ($mulai && $selesai) {
            return $now->between($mulai, $selesai);
        }

        return true; // jika jadwal belum diset, default manual ON
    }
}