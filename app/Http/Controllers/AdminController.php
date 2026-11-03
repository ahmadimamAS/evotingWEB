<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Siswa;
use App\Models\Kandidat;
use App\Models\Voting;
use App\Models\Setting;
use Carbon\Carbon;
class AdminController extends Controller
{
    // Dashboard Admin
    public function dashboard()
    {
        $totalSiswa = Siswa::count();
        $totalMemilih = Voting::distinct('siswa_id')->count('siswa_id');
        $totalKandidat = Kandidat::count();
        $votingAktif = Setting::get('voting_aktif', '0') === '1';
        
        // Get voting results
        $hasilVoting = [];
        $kandidats = Kandidat::all();
        foreach ($kandidats as $kandidat) {
            $hasilVoting[$kandidat->id] = Voting::where('kandidat_id', $kandidat->id)->count();
        }

        return view('admin.dashboard', compact('totalSiswa', 'totalMemilih', 'totalKandidat', 'votingAktif', 'hasilVoting', 'kandidats'));
    }

    // ===== CRUD SISWA =====

    // List Siswa
    public function siswaIndex()
    {
        $siswas = Siswa::all();
        return view('admin.siswa.index', compact('siswas'));
    }

    // Tambah Siswa
    public function siswaStore(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:siswas',
            'nama' => 'required',
            'kelas' => 'required',
            'password' => 'required|min:6',
        ]);

        Siswa::create([
            'nik' => $request->nik,
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil ditambahkan');
    }

    // Edit Siswa
    public function siswaUpdate(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);
        
        $request->validate([
            'nik' => 'required|unique:siswas,nik,' . $id,
            'nama' => 'required',
            'kelas' => 'required',
        ]);

        $data = [
            'nik' => $request->nik,
            'nama' => $request->nama,
            'kelas' => $request->kelas,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }
        $siswa->update($data);
        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diperbarui');
    }

    // Hapus Siswa
    public function siswaDestroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();
        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil dihapus');
    }

    // Reset memilih status
    public function siswaReset($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->update(['status_memilih' => false]);
        
        // Also delete their voting records
        Voting::where('siswa_id', $id)->delete();
        
        return redirect()->route('admin.siswa.index')->with('success', 'Status memilih siswa berhasil direset');
    }

    // ===== CRUD KANDIDAT =====

    // List Kandidat
    public function kandidatIndex()
    {
        $kandidats = Kandidat::orderBy('no_urut')->get();
        return view('admin.kandidat.index', compact('kandidats'));
    }

    // Tambah Kandidat
    public function kandidatStore(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'kelas' => 'required',
            'visi' => 'required',
            'misi' => 'required',
            'no_urut' => 'required|unique:kandidats',
            'foto' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'visi' => $request->visi,
            'misi' => $request->misi,
            'no_urut' => $request->no_urut,
        ];

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/kandidat'), $filename);
            $data['foto'] = $filename;
        }

        Kandidat::create($data);

        return redirect()->route('admin.kandidat.index')->with('success', 'Data kandidat berhasil ditambahkan');
    }

    // Edit Kandidat
    public function kandidatUpdate(Request $request, $id)
    {
        $kandidat = Kandidat::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'kelas' => 'required',
            'visi' => 'required',
            'misi' => 'required',
            'no_urut' => 'required|unique:kandidats,no_urut,' . $id,
            'foto' => 'image|mimes:jpeg,png,jpg|max:2048',
            name 
        ]);

        $data = [
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'visi' => $request->visi,
            'misi' => $request->misi,
            'no_urut' => $request->no_urut,
        ];

        if ($request->hasFile('foto')) {
            // Delete old photo
            if ($kandidat->foto && file_exists(public_path('uploads/kandidat/' . $kandidat->foto))) {
                unlink(public_path('uploads/kandidat/' . $kandidat->foto));
            }
            
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/kandidat'), $filename);
            $data['foto'] = $filename;
        }

        $kandidat->update($data);

        return redirect()->route('admin.kandidat.index')->with('success', 'Data kandidat berhasil diperbarui');
    }

    // Hapus Kandidat
    public function kandidatDestroy($id)
    {
        $kandidat = Kandidat::findOrFail($id);
        
        // Delete photo
        if ($kandidat->foto && file_exists(public_path('uploads/kandidat/' . $kandidat->foto))) {
            unlink(public_path('uploads/kandidat/' . $kandidat->foto));
        }
        
        $kandidat->delete();
        return redirect()->route('admin.kandidat.index')->with('success', 'Data kandidat berhasil dihapus');
    }

    // ===== PENGATURAN VOTING =====

    // Pengaturan Voting
    public function pengaturan()
{
    $votingAktifManual = Setting::get('voting_aktif', '0') === '1';
    $waktuMulai = Setting::get('waktu_mulai');
    $waktuSelesai = Setting::get('waktu_selesai');

    $votingAktifOtomatis = false;
    if ($waktuMulai && $waktuSelesai) {
        $votingAktifOtomatis = Carbon::now()->between(
            Carbon::parse($waktuMulai),
            Carbon::parse($waktuSelesai)
        );
    }

    return view('admin.pengaturan', compact(
        'votingAktifManual',
        'waktuMulai',
        'waktuSelesai',
        'votingAktifOtomatis'
    ));
}


    // Update Pengaturan
    public function pengaturanUpdate(Request $request)
    {
        if ($request->has('voting_aktif')) {
            Setting::set('voting_aktif', '1');
        } else {
            Setting::set('voting_aktif', '0');
        }

        Setting::set('waktu_mulai', $request->waktu_mulai);
        Setting::set('waktu_selesai', $request->waktu_selesai);

        return redirect()->route('admin.pengaturan')->with('success', 'Pengaturan voting berhasil diperbarui');
    }

    // ===== HASIL VOTING =====

    public function hasil()
    {
        $kandidats = Kandidat::orderBy('no_urut')->get();
        $totalSuara = Voting::count();
        
        $hasilVoting = [];
        foreach ($kandidats as $kandidat) {
            $count = Voting::where('kandidat_id', $kandidat->id)->count();
            $persen = $totalSuara > 0 ? round(($count / $totalSuara) * 100, 1) : 0;
            $hasilVoting[] = [
                'kandidat' => $kandidat,
                'suara' => $count,
                'persen' => $persen,
            ];
        }

        return view('admin.hasil', compact('hasilVoting', 'totalSuara'));
    }

    // Reset semua voting
    public function resetVoting()
{
    // Hapus semua voting
    Voting::truncate();

    // Reset status semua siswa
    Siswa::query()->update(['status_memilih' => false]);

    // Nonaktifkan voting
    Setting::set('voting_aktif', '0');

    return redirect()->route('admin.dashboard')->with('success', 'Voting berhasil direset');
}
}

