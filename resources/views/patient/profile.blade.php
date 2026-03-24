@extends('layouts.app')

@section('content')
<div class="py-6 sm:py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-4 sm:mb-6">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Profile Card -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="px-4 sm:px-6 py-4 bg-gradient-to-r from-indigo-600 to-blue-600 text-white">
                <div class="flex items-center gap-3 sm:gap-4">
                    @if(!empty($profile->profile_photo_path))
                        <img
                            src="{{ asset('storage/' . $profile->profile_photo_path) }}"
                            alt="Foto profil {{ $user->name }}"
                            class="w-12 h-12 sm:w-16 sm:h-16 rounded-full object-cover border-2 border-white/70 shadow shrink-0"
                        >
                    @else
                        <div class="w-12 h-12 sm:w-16 sm:h-16 rounded-full bg-white/20 flex items-center justify-center text-xl sm:text-2xl font-bold shrink-0">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <h2 class="text-2xl font-bold">Profil Saya</h2>
                        <p class="text-indigo-100">Kelola informasi data diri Anda</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('patient.profile.update') }}" method="POST" enctype="multipart/form-data" class="px-4 sm:px-6 py-4 sm:py-6">
                @csrf
                @method('PUT')

                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-100 border border-green-300 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-700 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Data Akun -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b">📧 Data Akun</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" value="{{ $user->name }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" disabled>
                            <p class="text-xs text-gray-500 mt-1">Nama tidak dapat diubah di sini</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" value="{{ $user->email }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" disabled>
                            <p class="text-xs text-gray-500 mt-1">Email tidak dapat diubah di sini</p>
                        </div>
                    </div>
                </div>

                <!-- Data Identitas -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b">🪪 Data Identitas</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="nik" class="block text-sm font-medium text-gray-700 mb-1">NIK (Nomor Induk Kependudukan)</label>
                            <input type="text" id="nik" name="nik" value="{{ old('nik', $profile->nik) }}" maxlength="16" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="16 digit NIK">
                        </div>
                        <div>
                            <label for="no_bpjs" class="block text-sm font-medium text-gray-700 mb-1">No. BPJS</label>
                            <input type="text" id="no_bpjs" name="no_bpjs" value="{{ old('no_bpjs', $profile->no_bpjs) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Nomor kartu BPJS">
                        </div>
                    </div>
                </div>

                <!-- Data Pribadi -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b">👤 Data Pribadi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                            <select id="jenis_kelamin" name="jenis_kelamin" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">-- Pilih --</option>
                                <option value="L" {{ old('jenis_kelamin', $profile->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin', $profile->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir</label>
                            <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $profile->tempat_lahir) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                            <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $profile->tanggal_lahir?->format('Y-m-d')) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label for="golongan_darah" class="block text-sm font-medium text-gray-700 mb-1">Golongan Darah</label>
                            <select id="golongan_darah" name="golongan_darah" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">-- Pilih --</option>
                                @foreach(['A', 'B', 'AB', 'O'] as $gol)
                                    <option value="{{ $gol }}" {{ old('golongan_darah', $profile->golongan_darah) == $gol ? 'selected' : '' }}>{{ $gol }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="pekerjaan" class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan</label>
                            <input type="text" id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan', $profile->pekerjaan) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label for="pendidikan" class="block text-sm font-medium text-gray-700 mb-1">Pendidikan Terakhir</label>
                            <select id="pendidikan" name="pendidikan" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">-- Pilih --</option>
                                @foreach(['Tidak Sekolah', 'SD', 'SMP', 'SMA/SMK', 'D1', 'D2', 'D3', 'D4/S1', 'S2', 'S3'] as $pend)
                                    <option value="{{ $pend }}" {{ old('pendidikan', $profile->pendidikan) == $pend ? 'selected' : '' }}>{{ $pend }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="status_pernikahan" class="block text-sm font-medium text-gray-700 mb-1">Status Pernikahan</label>
                            <select id="status_pernikahan" name="status_pernikahan" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">-- Pilih --</option>
                                @foreach(['Belum Menikah', 'Menikah', 'Cerai Hidup', 'Cerai Mati'] as $stat)
                                    <option value="{{ $stat }}" {{ old('status_pernikahan', $profile->status_pernikahan) == $stat ? 'selected' : '' }}>{{ $stat }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Alamat -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b">🏠 Alamat</h3>
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                            <textarea id="alamat" name="alamat" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Jalan, nomor rumah, dll">{{ old('alamat', $profile->alamat) }}</textarea>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                        <div>
                            <label for="rt" class="block text-sm font-medium text-gray-700 mb-1">RT</label>
                            <input type="text" id="rt" name="rt" value="{{ old('rt', $profile->rt) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label for="rw" class="block text-sm font-medium text-gray-700 mb-1">RW</label>
                            <input type="text" id="rw" name="rw" value="{{ old('rw', $profile->rw) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label for="kelurahan" class="block text-sm font-medium text-gray-700 mb-1">Kelurahan/Desa</label>
                            <input type="text" id="kelurahan" name="kelurahan" value="{{ old('kelurahan', $profile->kelurahan) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label for="kecamatan" class="block text-sm font-medium text-gray-700 mb-1">Kecamatan</label>
                            <input type="text" id="kecamatan" name="kecamatan" value="{{ old('kecamatan', $profile->kecamatan) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                        <div>
                            <label for="kota" class="block text-sm font-medium text-gray-700 mb-1">Kota/Kabupaten</label>
                            <input type="text" id="kota" name="kota" value="{{ old('kota', $profile->kota) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label for="provinsi" class="block text-sm font-medium text-gray-700 mb-1">Provinsi</label>
                            <input type="text" id="provinsi" name="provinsi" value="{{ old('provinsi', $profile->provinsi) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label for="kode_pos" class="block text-sm font-medium text-gray-700 mb-1">Kode Pos</label>
                            <input type="text" id="kode_pos" name="kode_pos" value="{{ old('kode_pos', $profile->kode_pos) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>
                </div>

                <!-- Kontak -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b">📞 Kontak</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="no_telepon" class="block text-sm font-medium text-gray-700 mb-1">No. Telepon Rumah</label>
                            <input type="text" id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $profile->no_telepon) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-1">No. HP/WhatsApp</label>
                            <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', $profile->no_hp) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>
                </div>

                <!-- Kontak Darurat -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b">🆘 Kontak Darurat / Penanggung Jawab</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="nama_keluarga" class="block text-sm font-medium text-gray-700 mb-1">Nama Keluarga</label>
                            <input type="text" id="nama_keluarga" name="nama_keluarga" value="{{ old('nama_keluarga', $profile->nama_keluarga) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label for="hubungan_keluarga" class="block text-sm font-medium text-gray-700 mb-1">Hubungan</label>
                            <select id="hubungan_keluarga" name="hubungan_keluarga" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">-- Pilih --</option>
                                @foreach(['Suami', 'Istri', 'Orang Tua', 'Anak', 'Saudara', 'Lainnya'] as $hub)
                                    <option value="{{ $hub }}" {{ old('hubungan_keluarga', $profile->hubungan_keluarga) == $hub ? 'selected' : '' }}>{{ $hub }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="no_telepon_keluarga" class="block text-sm font-medium text-gray-700 mb-1">No. Telepon Keluarga</label>
                            <input type="text" id="no_telepon_keluarga" name="no_telepon_keluarga" value="{{ old('no_telepon_keluarga', $profile->no_telepon_keluarga) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>
                </div>

                <!-- Riwayat Kesehatan -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b">💊 Riwayat Kesehatan</h3>
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label for="riwayat_alergi" class="block text-sm font-medium text-gray-700 mb-1">Riwayat Alergi</label>
                            <textarea id="riwayat_alergi" name="riwayat_alergi" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Contoh: Alergi obat penisilin, alergi seafood, dll">{{ old('riwayat_alergi', $profile->riwayat_alergi) }}</textarea>
                        </div>
                        <div>
                            <label for="riwayat_penyakit" class="block text-sm font-medium text-gray-700 mb-1">Riwayat Penyakit</label>
                            <textarea id="riwayat_penyakit" name="riwayat_penyakit" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Contoh: Hipertensi, Diabetes, Asma, dll">{{ old('riwayat_penyakit', $profile->riwayat_penyakit) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Foto Profil & Dokumen Identitas -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b">📎 Foto Profil & Dokumen Identitas</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="profile_photo" class="block text-sm font-medium text-gray-700 mb-1">Foto Profil</label>
                            <input type="file" id="profile_photo" name="profile_photo" accept=".jpg,.jpeg,.png,.webp" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            @if($profile->profile_photo_path)
                                <a href="{{ asset('storage/' . $profile->profile_photo_path) }}" target="_blank" class="text-xs text-indigo-600 hover:underline mt-1 inline-block">Lihat file tersimpan</a>
                            @endif
                        </div>
                        <div>
                            <label for="ktp_photo" class="block text-sm font-medium text-gray-700 mb-1">Foto KTP</label>
                            <input type="file" id="ktp_photo" name="ktp_photo" accept=".jpg,.jpeg,.png,.webp,.pdf" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            @if($profile->ktp_photo_path)
                                <a href="{{ asset('storage/' . $profile->ktp_photo_path) }}" target="_blank" class="text-xs text-indigo-600 hover:underline mt-1 inline-block">Lihat file tersimpan</a>
                            @endif
                        </div>
                        <div>
                            <label for="kk_photo" class="block text-sm font-medium text-gray-700 mb-1">Foto Kartu Keluarga</label>
                            <input type="file" id="kk_photo" name="kk_photo" accept=".jpg,.jpeg,.png,.webp,.pdf" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            @if($profile->kk_photo_path)
                                <a href="{{ asset('storage/' . $profile->kk_photo_path) }}" target="_blank" class="text-xs text-indigo-600 hover:underline mt-1 inline-block">Lihat file tersimpan</a>
                            @endif
                        </div>
                        <div>
                            <label for="bpjs_photo" class="block text-sm font-medium text-gray-700 mb-1">Foto Kartu BPJS</label>
                            <input type="file" id="bpjs_photo" name="bpjs_photo" accept=".jpg,.jpeg,.png,.webp,.pdf" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            @if($profile->bpjs_photo_path)
                                <a href="{{ asset('storage/' . $profile->bpjs_photo_path) }}" target="_blank" class="text-xs text-indigo-600 hover:underline mt-1 inline-block">Lihat file tersimpan</a>
                            @endif
                        </div>
                        <div>
                            <label for="rme_card_photo" class="block text-sm font-medium text-gray-700 mb-1">Foto Kartu RME</label>
                            <input type="file" id="rme_card_photo" name="rme_card_photo" accept=".jpg,.jpeg,.png,.webp,.pdf" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            @if($profile->rme_card_photo_path)
                                <a href="{{ asset('storage/' . $profile->rme_card_photo_path) }}" target="_blank" class="text-xs text-indigo-600 hover:underline mt-1 inline-block">Lihat file tersimpan</a>
                            @endif
                        </div>
                        <div>
                            <label for="supporting_identity_photo" class="block text-sm font-medium text-gray-700 mb-1">Identitas Pendukung Lainnya</label>
                            <input type="file" id="supporting_identity_photo" name="supporting_identity_photo" accept=".jpg,.jpeg,.png,.webp,.pdf" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            @if($profile->supporting_identity_photo_path)
                                <a href="{{ asset('storage/' . $profile->supporting_identity_photo_path) }}" target="_blank" class="text-xs text-indigo-600 hover:underline mt-1 inline-block">Lihat file tersimpan</a>
                            @endif
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-3">Format file: JPG, PNG, WEBP, PDF. Maksimal 4MB per dokumen.</p>
                </div>

                <!-- Submit -->
                <div class="flex justify-end gap-3">
                    <a href="{{ route('dashboard') }}" class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-semibold">
                        💾 Simpan Profil
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
