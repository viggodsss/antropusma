# Catatan: Penggunaan Prototyping dalam Metode R&D
## Proyek: Sistem Antrian Berbasis Web dengan Barcode (FIFO)

---

## 1. Apakah Prototyping Berguna dalam Metode R&D?

**Ya, sangat berguna.** Metode Research and Development (R&D) berfokus pada pengembangan produk secara sistematis dan terukur. Dalam konteks pengembangan sistem informasi, Prototyping dapat diintegrasikan ke dalam siklus R&D sebagai pendekatan iteratif yang memungkinkan validasi kebutuhan lebih awal dan pengurangan risiko kesalahan desain.

Pada proyek ini — *Sistem Antrian Berbasis Web dengan Barcode (FIFO)* yang melibatkan tiga peran pengguna (Admin, Petugas Klaster, dan Pasien) — Prototyping sangat relevan karena setiap peran memiliki kebutuhan antarmuka dan alur kerja yang berbeda. Dengan membuat prototipe secara bertahap, pengembang dapat memastikan bahwa setiap peran mendapatkan pengalaman yang sesuai sebelum sistem benar-benar diimplementasikan secara penuh.

---

## 2. Manfaat Prototyping dalam R&D

| No. | Manfaat | Relevansi dengan Proyek Ini |
|-----|---------|----------------------------|
| 1 | **Umpan balik dini dari pengguna** | Pasien, Petugas Klaster, dan Admin dapat langsung menguji alur antrian sebelum sistem selesai dibangun. |
| 2 | **Validasi kebutuhan lebih cepat** | Kebutuhan fungsional seperti cetak barcode, scan kedatangan, dan panggilan nomor bisa dikonfirmasi sejak awal. |
| 3 | **Mengurangi kesalahan desain** | Perubahan pada antarmuka atau logika FIFO lebih murah dilakukan di tahap prototipe daripada setelah implementasi penuh. |
| 4 | **Meningkatkan komunikasi tim** | Prototipe visual memudahkan diskusi antara pengembang dan pemangku kepentingan (dosen pembimbing, pihak instansi). |
| 5 | **Mempercepat iterasi perbaikan** | Setiap iterasi menghasilkan versi sistem yang lebih baik berdasarkan temuan nyata, bukan asumsi semata. |

---

## 3. Rencana Iterasi yang Direkomendasikan (3 Iterasi)

Berikut rencana tiga iterasi yang dapat diterapkan dalam proyek ini:

### Iterasi 1 — Prototipe Awal (Kebutuhan Dasar)
- **Fokus:** Alur registrasi Pasien dan penerbitan tiket/barcode.
- **Fitur yang dibangun:** Halaman registrasi Pasien, generate barcode/QR code, tampilan nomor antrian.
- **Responden uji:** 3–5 Pasien dan 1 Petugas Klaster.
- **Output:** Daftar temuan kebutuhan yang belum terpenuhi, perbaikan desain antarmuka.

### Iterasi 2 — Prototipe Pengembangan (Alur Utama)
- **Fokus:** Proses scan kedatangan oleh Petugas Klaster, mekanisme antrian FIFO, dan pemanggilan nomor.
- **Fitur yang dibangun:** Modul scan barcode, dashboard antrian Petugas Klaster, layar tampilan nomor publik.
- **Responden uji:** 2–3 Petugas Klaster dan 5–10 Pasien.
- **Output:** Perbaikan logika FIFO, penyesuaian tampilan dashboard, penanganan kasus khusus (pasien terlambat, batal antri).

### Iterasi 3 — Prototipe Akhir (Manajemen & Laporan)
- **Fokus:** Modul Admin — manajemen akun pengguna, konfigurasi layanan, dan laporan kinerja.
- **Fitur yang dibangun:** Dashboard Admin, manajemen role (Admin/Petugas Klaster/Pasien), laporan harian/mingguan, pengaturan klaster layanan.
- **Responden uji:** 1–2 Admin dan perwakilan semua peran.
- **Output:** Sistem siap untuk User Acceptance Testing (UAT) penuh, dokumentasi final prototipe.

---

## 4. Kriteria Penerimaan (Acceptance Criteria) — Contoh per Peran

### Pasien
- [ ] Pasien dapat mendaftar dan menerima tiket dengan barcode dalam waktu ≤ 30 detik.
- [ ] Pasien dapat melihat estimasi waktu tunggu di layar publik.
- [ ] Barcode yang dicetak/ditampilkan dapat dipindai oleh pemindai petugas tanpa error.

### Petugas Klaster
- [ ] Petugas dapat memindai barcode dan sistem secara otomatis memasukkan pasien ke antrian FIFO.
- [ ] Petugas dapat memanggil nomor berikutnya dengan satu klik/aksi.
- [ ] Sistem menampilkan notifikasi jika barcode tidak valid atau tiket sudah digunakan.

### Admin
- [ ] Admin dapat membuat, mengubah, dan menonaktifkan akun Petugas Klaster.
- [ ] Admin dapat menghasilkan laporan rekapitulasi antrian (rata-rata waktu tunggu, jumlah pasien dilayani) dalam format yang dapat diekspor.
- [ ] Admin dapat mengonfigurasi jumlah klaster dan kapasitas layanan per klaster.

---

## 5. Cara Mendokumentasikan Hasil Prototipe dalam Skripsi

Setiap iterasi sebaiknya didokumentasikan dalam skripsi, terutama di **Bab III (Metodologi Penelitian)** dan **Bab IV (Hasil dan Pembahasan)**. Berikut panduannya:

### Di Bab III — Metodologi
- Jelaskan bahwa metode pengembangan sistem yang digunakan adalah **Prototyping** sebagai bagian dari pendekatan R&D.
- Sertakan diagram/bagan siklus Prototyping yang menggambarkan alur: Identifikasi Kebutuhan → Rancang Prototipe → Uji Prototipe → Evaluasi & Perbaikan → (Ulangi hingga diterima).
- Tuliskan rencana tiga iterasi seperti pada bagian 3 di atas.

### Di Bab IV — Hasil dan Pembahasan
- **Iterasi 1:** Tampilkan tangkapan layar antarmuka awal, hasil kuesioner/wawancara singkat, daftar perbaikan yang ditemukan.
- **Iterasi 2:** Tampilkan perbaikan yang diterapkan, hasil pengujian fungsional (tabel test case), perbandingan dengan iterasi sebelumnya.
- **Iterasi 3:** Tampilkan versi final prototipe, hasil UAT (tabel rekapitulasi), analisis tingkat kepuasan pengguna per peran.

### Template Tabel Dokumentasi Iterasi

| Iterasi | Fitur yang Diuji | Temuan/Masalah | Perbaikan yang Dilakukan | Status |
|---------|-----------------|----------------|--------------------------|--------|
| 1 | Registrasi & Barcode | ... | ... | Selesai |
| 2 | Scan & Antrian FIFO | ... | ... | Selesai |
| 3 | Dashboard Admin & Laporan | ... | ... | Selesai |

---

## 6. Risiko dan Mitigasi

| No. | Risiko | Dampak | Mitigasi |
|-----|--------|--------|----------|
| 1 | **Scope creep** — pengguna terus meminta fitur baru di setiap iterasi | Proyek tidak selesai tepat waktu | Tetapkan batas fitur (feature freeze) di awal setiap iterasi; gunakan backlog untuk fitur tambahan. |
| 2 | **Ketergantungan pada responden** — sulit mengumpulkan Pasien/Petugas untuk setiap iterasi | Validasi tidak representatif | Jadwalkan sesi uji jauh-jauh hari; gunakan mock user jika responden asli tidak tersedia. |
| 3 | **Prototipe disalahartikan sebagai produk final** | Ekspektasi berlebihan dari pihak instansi | Komunikasikan secara eksplisit bahwa ini adalah prototipe, bukan sistem produksi. |
| 4 | **Inkonsistensi antarmuka antar iterasi** | Pengguna bingung saat pengujian | Gunakan design system atau template UI yang konsisten sejak Iterasi 1. |
| 5 | **Integrasi barcode bermasalah** (scanner tidak kompatibel) | Alur verifikasi Petugas Klaster gagal | Uji kompatibilitas scanner di Iterasi 1; siapkan fallback input manual. |
| 6 | **Data uji tidak representatif** | Hasil evaluasi kurang valid | Gunakan skenario uji yang mencakup kondisi normal dan kondisi ekstrem (antrian panjang, barcode rusak). |

---

## Referensi Singkat

- Borg, W. R., & Gall, M. D. (1983). *Educational Research: An Introduction*. Longman.
- Pressman, R. S. (2014). *Software Engineering: A Practitioner's Approach* (8th ed.). McGraw-Hill.
- Sommerville, I. (2016). *Software Engineering* (10th ed.). Pearson.

---

*Catatan ini dibuat sebagai panduan tambahan untuk skripsi "Sistem Antrian Berbasis Web dengan Barcode (FIFO)" dan tidak menggantikan bimbingan dosen pembimbing.*
