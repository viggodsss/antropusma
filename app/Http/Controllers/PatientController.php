<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PatientController extends Controller
{
    /**
     * Tampilkan form pendaftaran
     */
    public function showForm(): View
    {
        return view('daftar');
    }

    /**
     * Simpan data pasien
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_identitas' => 'required|string|max:255|unique:pasiens,no_identitas',
        ]);

        Pasien::create($validated);

        return back()->with('success', 'Pendaftaran berhasil!');
    }

    /**
     * Dashboard pasien
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Optional safety check (kalau route belum pakai middleware auth)
        if (!$user) {
            return redirect()->route('login');
        }

        return view('patient.dashboard', [
            'user' => $user,
        ]);
    }
}