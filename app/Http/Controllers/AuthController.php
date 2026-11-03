<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Siswa;

class AuthController extends Controller
{
    // Show login form for admin
    public function showAdminLogin()
    {
        return view('auth.admin-login');
    }

    // Show login form for siswa
    public function showSiswaLogin()
    {
        return view('auth.siswa-login');
    }

    // Show registration form for siswa
    public function showSiswaRegister()
    {
        return view('auth.siswa-registrasi');
    }

    // Handle siswa registration (self-register)
    public function siswaRegister(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|unique:siswas,nik',
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string|min:6',
        ]);

        // Validasi NIK versi lokal (tanpa API DUKCAPIL)
        $nik = preg_replace('/\s+/', '', $validated['nik']);
        if (!$this->isValidNikIndonesia($nik)) {
            return back()->withErrors([
                'nik' => 'NIK tidak valid. Pastikan NIK 16 digit angka dan sesuai format validasi lokal.',
            ])->withInput();
        }

        $siswa = Siswa::create([
            'nik' => $nik,
            'nama' => $validated['nama'],
            'kelas' => $validated['kelas'],
            'password' => Hash::make($validated['password']),
            'status_memilih' => false,
        ]);

        Auth::guard('siswa')->login($siswa);
        $request->session()->regenerate();

        return redirect()->intended('/siswa/dashboard');
    }

    private function isValidNikIndonesia(string $nik): bool
    {
        // NIK Indonesia: 16 digit angka
        if (!preg_match('/^\d{16}$/', $nik)) {
            return false;
        }

        // Validasi checksum lokal sederhana (bukan pengganti DUKCAPIL)
        // Ambil 16 digit, lakukan mod-11 pada 15 digit pertama terhadap digit ke-16.
        // Ini hanya untuk mencegah input asal/typo.
        $digits = array_map('intval', str_split($nik));
        $first15 = array_slice($digits, 0, 15);
        $last = $digits[15];

        $sum = 0;
        foreach ($first15 as $i => $d) {
            // bobot 2..16
            $sum += $d * ($i + 2);
        }
        $check = $sum % 11;
        return $check === $last;
    }

    // Handle admin login
    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $admin = Admin::where('username', $credentials['username'])->first();

        if ($admin && Hash::check($credentials['password'], $admin->password)) {
            Auth::login($admin);
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->withInput();
    }

    // Handle siswa login
    public function siswaLogin(Request $request)
    {
        $credentials = $request->validate([
            'nik' => 'required',
            'password' => 'required',
        ]);

        $siswa = Siswa::where('nik', $credentials['nik'])->first();

        if ($siswa && Hash::check($credentials['password'], $siswa->password)) {
            Auth::guard('siswa')->login($siswa); // <-- pakai guard siswa
            $request->session()->regenerate();
            return redirect()->intended('/siswa/dashboard');
        }

        return back()->withErrors([
            'nik' => 'NIK atau password salah.',
        ])->withInput();
    }

    // Handle logout
    public function logout(Request $request)
    {
        // Logout admin jika login
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }

        // Logout siswa jika login
        if (Auth::guard('siswa')->check()) {
            Auth::guard('siswa')->logout();
        }

        // Hapus session dan token CSRF
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); // redirect ke landing page
    }
}

