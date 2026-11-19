<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KaryawanAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('karyawan.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! $user->isKaryawan()) {
            return back()->withErrors([
                'email' => 'Akun karyawan tidak ditemukan atau tidak memiliki akses.',
            ]);
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('karyawan.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function dashboard()
    {
        if (! Auth::check()) {
            return redirect()->route('karyawan.login');
        }

        $user = Auth::user();
        $karyawan = Karyawan::where('user_id', $user->id)->first();

        if (! $karyawan) {
            abort(403, 'Akun Anda belum terhubung dengan data karyawan.');
        }

        $presensiHariIni = Absensi::where('karyawan_id', $karyawan->id)
            ->whereDate('tanggal', now())
            ->first();

        return view('karyawan.dashboard', compact('karyawan', 'presensiHariIni'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('karyawan.login');
    }
}
