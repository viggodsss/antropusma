# BAB III
# METODOLOGI PENELITIAN

## 3.1 Jenis Penelitian

Penelitian ini menggunakan pendekatan **Research and Development (R&D)** yang diintegrasikan dengan strategi **Prototyping** iteratif. Pendekatan R&D dipilih karena penelitian ini bertujuan menghasilkan produk berupa sistem informasi antrian berbasis barcode dan FIFO yang dapat langsung diterapkan di [nama instansi]. Integrasi Prototyping memungkinkan pengembangan dilakukan secara bertahap melalui tiga iterasi masing-masing berdurasi dua minggu, dengan umpan balik pemangku kepentingan dikumpulkan dan ditindaklanjuti pada setiap akhir iterasi sebelum melanjutkan ke iterasi berikutnya.

## 3.2 Tempat dan Waktu Penelitian

Penelitian dilaksanakan di **[nama instansi]**, berlokasi di **[alamat instansi]**. Periode penelitian direncanakan berlangsung dari **[bulan awal, tahun]** hingga **[bulan akhir, tahun]**, dengan durasi pengembangan inti selama enam minggu yang dibagi menjadi tiga iterasi.

## 3.3 Populasi dan Sampel

### 3.3.1 Populasi

Populasi penelitian ini meliputi seluruh pemangku kepentingan yang terlibat dalam proses antrian di [nama instansi], yaitu:

- **Admin**: staf pengelola sistem informasi atau manajemen yang bertanggung jawab atas konfigurasi dan pelaporan;
- **Petugas Klaster**: seluruh petugas yang bertugas di loket pelayanan;
- **Pasien**: seluruh pasien/pengunjung yang menggunakan layanan antrian di [nama instansi].

### 3.3.2 Sampel

Pengambilan sampel dilakukan dengan teknik *purposive sampling* berdasarkan keterwakilan peran dan kesediaan partisipan. Rencana jumlah sampel adalah sebagai berikut.

| Peran | Jumlah Sampel | Keterangan |
|---|---|---|
| Admin | [X] orang | Manajemen sistem dan pelaporan |
| Petugas Klaster | [X] orang | Operator loket aktif |
| Pasien | [X] orang | Pengguna layanan periode penelitian |

Ukuran sampel di atas bersifat sementara dan akan disesuaikan setelah konfirmasi dengan pihak [nama instansi] pada tahap analisis kebutuhan.

## 3.4 Teknik Pengumpulan Data

Pengumpulan data dilakukan dengan beberapa teknik yang saling melengkapi, yaitu:

1. **Wawancara** — Wawancara semi-terstruktur dilakukan dengan perwakilan Admin ([X] orang), Petugas Klaster ([X] orang), dan Pasien ([X] orang) untuk menggali kebutuhan, permasalahan, dan harapan terhadap sistem antrian yang akan dikembangkan.

2. **Observasi** — Pengamatan langsung terhadap alur antrian yang berjalan saat ini di [nama instansi] untuk memahami pola kedatangan, waktu tunggu, dan interaksi antar peran.

3. **Dokumentasi** — Studi dokumen meliputi SOP antrian yang ada, format laporan yang digunakan, dan regulasi terkait pelayanan di [nama instansi].

4. **Kuesioner/UAT** — Pada setiap akhir iterasi, kuesioner *User Acceptance Testing* (UAT) diberikan kepada responden untuk mengukur tingkat penerimaan dan kepuasan terhadap prototipe yang dihasilkan.

## 3.5 Metode Pengembangan Sistem: R&D Terintegrasi Prototyping

Pengembangan sistem mengikuti alur R&D yang diintegrasikan dengan siklus Prototyping iteratif. Secara keseluruhan, alur pengembangan terdiri dari tahap-tahap berikut yang kemudian diimplementasikan dalam tiga iterasi.

```
[Identifikasi Masalah & Kebutuhan]
        ↓
[Kajian Literatur & Desain Konseptual]
        ↓
┌──────────────────────────────────────────┐
│  ITERASI 1 (Minggu 1–2)                  │
│  Prototipe Inti: registrasi, tiket,      │
│  antrian FIFO dasar                      │
└──────────────┬───────────────────────────┘
               ↓ Evaluasi & Revisi
┌──────────────────────────────────────────┐
│  ITERASI 2 (Minggu 3–4)                  │
│  Prototipe Pengembangan: scan barcode,   │
│  dashboard petugas, notifikasi           │
└──────────────┬───────────────────────────┘
               ↓ Evaluasi & Revisi
┌──────────────────────────────────────────┐
│  ITERASI 3 (Minggu 5–6)                  │
│  Prototipe Final: laporan, RBAC,         │
│  penyempurnaan UI, UAT final             │
└──────────────┬───────────────────────────┘
               ↓
[Dokumentasi & Pelaporan Akhir]
```

### 3.5.1 Tahap Identifikasi Masalah dan Kebutuhan

Pada tahap ini dilakukan analisis terhadap kondisi antrian yang berjalan saat ini di [nama instansi]. Permasalahan yang diidentifikasi meliputi: [deskripsi masalah, mis. waktu tunggu yang panjang, pengelolaan antrian manual, tidak ada notifikasi, dll.]. Kebutuhan pemangku kepentingan dikumpulkan melalui wawancara dan observasi sebagaimana diuraikan pada Subbab 3.4.

### 3.5.2 Kajian Literatur dan Desain Konseptual

Kajian literatur mencakup teori antrian FIFO, teknologi barcode, RBAC, metodologi R&D, dan Prototyping (diuraikan di Bab II). Hasil kajian digunakan untuk merancang arsitektur sistem, model basis data konseptual, dan wireframe awal antarmuka yang menjadi acuan pengembangan prototipe pertama.

### 3.5.3 Iterasi Pengembangan

Pengembangan sistem dibagi menjadi **tiga iterasi**, masing-masing berdurasi **dua minggu**. Setiap iterasi mengikuti siklus: *Perencanaan → Pengembangan Cepat → Demonstrasi & Evaluasi → Revisi*.

---

#### 3.5.3.1 Iterasi 1 — Prototipe Inti (Minggu 1–2)

**Tujuan:** Membangun fondasi sistem yang mencakup registrasi pasien, penerbitan tiket dengan barcode, dan mekanisme antrian FIFO dasar.

**Fitur yang dikembangkan:**

| No. | Fitur | Peran yang Terlibat |
|---|---|---|
| 1 | Autentikasi pengguna (login/logout) | Admin, Petugas Klaster, Pasien |
| 2 | Registrasi pasien dan penerbitan tiket | Pasien, Petugas Klaster (loket) |
| 3 | Generate barcode unik per tiket | Sistem (otomatis) |
| 4 | Tampilan daftar antrian FIFO dasar | Petugas Klaster |
| 5 | Halaman status tiket untuk Pasien | Pasien |

**Jadwal Iterasi 1:**

| Hari | Kegiatan |
|---|---|
| 1–3 | Setup environment, struktur database, autentikasi |
| 4–6 | Modul registrasi dan generate tiket/barcode |
| 7–8 | Modul daftar antrian FIFO dan halaman status Pasien |
| 9–10 | Pengujian internal dan perbaikan bug |
| 11–14 | Demonstrasi prototipe kepada pemangku kepentingan, pengisian kuesioner UAT Iterasi 1, rekap umpan balik, dan revisi |

**Kriteria Penerimaan (Acceptance Criteria) Iterasi 1:**

- [ ] AC-1.1: Pasien dapat mendaftar dan menerima tiket dengan nomor unik dan barcode yang dapat dipindai.
- [ ] AC-1.2: Sistem menerapkan urutan FIFO — tiket yang lebih dahulu dibuat akan lebih dahulu muncul dalam daftar antrian.
- [ ] AC-1.3: Petugas Klaster dapat melihat daftar antrian yang aktif setelah login.
- [ ] AC-1.4: Pasien dapat melihat posisi antriannya melalui halaman status tiket.
- [ ] AC-1.5: Admin dapat login dan melihat halaman dasbor (meskipun belum ada data laporan penuh).
- [ ] AC-1.6: Tidak ada data tiket dari satu sesi yang dapat diakses oleh sesi pengguna lain yang tidak berwenang (validasi RBAC dasar).

**Mapping Peran → Aksi → Timestamp (Iterasi 1):**

| Peran | Aksi | Field Timestamp |
|---|---|---|
| Pasien | Registrasi dan request tiket | `tickets.created_at` |
| Sistem | Generate barcode | `tickets.created_at` |
| Petugas Klaster | Melihat daftar antrian | *(tidak ada timestamp, hanya baca)* |
| Pasien | Melihat status tiket | *(tidak ada timestamp, hanya baca)* |

---

#### 3.5.3.2 Iterasi 2 — Prototipe Pengembangan (Minggu 3–4)

**Tujuan:** Menambahkan fitur pemindaian barcode untuk pencatatan kedatangan, pemanggilan nomor antrian, dashboard operasional Petugas Klaster, notifikasi status antrian, dan pengiriman survei kepuasan pasien via email setelah pelayanan selesai.

**Fitur yang dikembangkan:**

| No. | Fitur | Peran yang Terlibat |
|---|---|---|
| 1 | Scan barcode untuk pencatatan kedatangan | Petugas Klaster |
| 2 | Tombol panggil nomor antrian | Petugas Klaster |
| 3 | Update status tiket (menunggu/dipanggil/dilayani/selesai) | Petugas Klaster |
| 4 | Layar tampilan nomor yang dipanggil (display publik) | Sistem |
| 5 | Notifikasi/indikator estimasi waktu tunggu | Pasien |
| 6 | Manajemen akun pengguna dasar | Admin |
| 7 | Pengiriman survei kepuasan otomatis via email setelah pelayanan selesai | Sistem (otomatis), Pasien (mengisi) |

**Jadwal Iterasi 2:**

| Hari | Kegiatan |
|---|---|
| 1–3 | Modul scan barcode dan pencatatan `arrival_time` |
| 4–5 | Modul panggil nomor, update status, dan `called_time` |
| 6–7 | Layar tampilan publik dan estimasi waktu tunggu untuk Pasien |
| 8–9 | Modul manajemen akun pengguna (Admin) |
| 10–11 | Pengujian internal dan perbaikan bug |
| 12–14 | Demonstrasi prototipe kepada pemangku kepentingan, pengisian kuesioner UAT Iterasi 2, rekap umpan balik, dan revisi |

**Kriteria Penerimaan (Acceptance Criteria) Iterasi 2:**

- [ ] AC-2.1: Petugas Klaster dapat memindai barcode dan sistem secara otomatis mencatat `arrival_time` pada tabel `queue_records`.
- [ ] AC-2.2: Setelah dipindai, tiket pasien berpindah dari status `scheduled` ke `waiting` dalam antrian aktif.
- [ ] AC-2.3: Saat Petugas Klaster menekan tombol "Panggil Nomor Berikutnya", sistem menampilkan nomor di layar publik dan mencatat `called_time`.
- [ ] AC-2.4: Petugas Klaster dapat menandai tiket sebagai "sedang dilayani" (`serving`) dan "selesai" (`done`), dengan `served_time` dan `finish_time` tercatat.
- [ ] AC-2.5: Pasien dapat melihat estimasi waktu tunggu yang diperbarui secara real-time (atau near-real-time).
- [ ] AC-2.6: Admin dapat menambah, menonaktifkan, dan mengubah peran akun pengguna.
- [ ] AC-2.7: Petugas Klaster tidak dapat mengakses halaman manajemen pengguna yang merupakan hak eksklusif Admin (validasi RBAC lengkap).
- [ ] AC-2.8: Setelah Petugas Klaster menandai tiket sebagai `done`, sistem secara otomatis mengirimkan email survei kepuasan ke alamat email pasien yang terdaftar; email diteruskan/disalin (*CC*) ke alamat email Admin yang dikonfigurasi di SMTP.
- [ ] AC-2.9: Email survei memuat tautan unik yang mengarah ke formulir survei untuk tiket bersangkutan; tautan hanya dapat digunakan satu kali (*single-use token*).

**Mapping Peran → Aksi → Timestamp (Iterasi 2):**

| Peran | Aksi | Field Timestamp |
|---|---|---|
| Petugas Klaster | Scan barcode (catat kedatangan) | `queue_records.arrival_time` |
| Petugas Klaster | Panggil nomor | `queue_records.called_time` |
| Petugas Klaster | Mulai pelayanan | `queue_records.served_time` |
| Petugas Klaster | Selesai pelayanan (trigger survei) | `queue_records.finish_time` |
| Sistem | Kirim email survei otomatis | `surveys.email_sent_at` |
| Admin | Buat/ubah akun pengguna | `users.updated_at` |

---

#### 3.5.3.3 Iterasi 3 — Prototipe Final dan Penyempurnaan (Minggu 5–6)

**Tujuan:** Melengkapi fitur pelaporan dan analitik, menyempurnakan antarmuka berdasarkan semua umpan balik sebelumnya, melakukan pengujian menyeluruh (termasuk UAT final), dan mempersiapkan sistem untuk *deployment*.

**Fitur yang dikembangkan:**

| No. | Fitur | Peran yang Terlibat |
|---|---|---|
| 1 | Laporan rata-rata waktu tunggu, throughput, dan utilisasi klaster | Admin |
| 2 | Ekspor laporan (CSV/PDF) dengan filter periode | Admin |
| 3 | Penyempurnaan UI/UX berdasarkan umpan balik Iterasi 1 & 2 | Semua |
| 4 | Pengaturan prioritas antrian (mis. lansia, darurat) | Admin |
| 5 | Pencatatan hasil pelayanan dan catatan petugas | Petugas Klaster |
| 6 | Halaman formulir survei kepuasan pasien (dari tautan email) | Pasien |
| 7 | Rekapitulasi dan tampilan hasil survei kepuasan di dasbor Admin | Admin |
| 8 | Backup dan keamanan sistem | Admin |
| 9 | Pengujian UAT final dengan semua pemangku kepentingan | Admin, Petugas Klaster, Pasien |

**Jadwal Iterasi 3:**

| Hari | Kegiatan |
|---|---|
| 1–3 | Modul laporan dan ekspor (Admin) |
| 4–5 | Fitur prioritas antrian dan catatan hasil pelayanan |
| 6–7 | Penyempurnaan UI/UX dan perbaikan bug komprehensif |
| 8–9 | Pengujian fungsional menyeluruh (semua modul) |
| 10–12 | UAT final dengan [X] Admin, [X] Petugas Klaster, [X] Pasien |
| 13–14 | Revisi akhir, dokumentasi teknis, persiapan *deployment* |

**Kriteria Penerimaan (Acceptance Criteria) Iterasi 3:**

- [ ] AC-3.1: Admin dapat menghasilkan laporan rata-rata waktu tunggu dan throughput untuk periode tanggal yang dipilih.
- [ ] AC-3.2: Laporan dapat diekspor dalam format CSV dan/atau PDF.
- [ ] AC-3.3: Sistem menerapkan aturan prioritas yang ditetapkan Admin — tiket dengan prioritas lebih tinggi ditampilkan lebih awal dalam antrian aktif.
- [ ] AC-3.4: Hasil UAT final menunjukkan tingkat penerimaan ≥ [X]% dari total responden ([X] Admin, [X] Petugas Klaster, [X] Pasien).
- [ ] AC-3.5: Seluruh alur sistem dari registrasi pasien hingga selesai pelayanan dapat diselesaikan tanpa error kritis dalam [X] skenario uji.
- [ ] AC-3.6: Waktu respons sistem untuk operasi utama (scan, panggil nomor) tidak melebihi [X] detik pada kondisi [X] pengguna bersamaan.
- [ ] AC-3.7: Seluruh data sensitif (kata sandi) tersimpan dalam bentuk *hash* dan akses ke halaman admin terlindungi oleh autentikasi.
- [ ] AC-3.8: Pasien dapat mengakses formulir survei kepuasan melalui tautan dalam email yang diterima; setelah formulir diisi dan dikirimkan, data survei tersimpan di basis data dan notifikasi email terkirim ke alamat Admin (SMTP) secara otomatis.
- [ ] AC-3.9: Admin dapat melihat rekapitulasi hasil survei kepuasan (skor rata-rata dan komentar) di dasbor, difilter berdasarkan periode dan klaster.

**Mapping Peran → Aksi → Timestamp (Iterasi 3):**

| Peran | Aksi | Field Timestamp |
|---|---|---|
| Petugas Klaster | Simpan catatan hasil pelayanan | `queue_records.notes_updated_at` |
| Pasien | Mengisi dan mengirimkan formulir survei | `surveys.submitted_at` |
| Sistem | Kirim notifikasi survei ke Admin via SMTP | `surveys.admin_notified_at` |
| Admin | Generate laporan | `reports.generated_at` |
| Admin | Ekspor laporan | `reports.exported_at` |
| Admin | Atur prioritas antrian | `services.priority_updated_at` |
| Admin | Backup database | `backups.created_at` |

---

### 3.5.4 Evaluasi dan Revisi Antar-Iterasi

Pada setiap akhir iterasi, evaluasi dilakukan melalui dua mekanisme:

1. **Pengujian fungsional internal** — tim pengembang menjalankan *test case* berdasarkan *acceptance criteria* iterasi berjalan. Semua *acceptance criteria* harus terpenuhi sebelum demonstrasi kepada pemangku kepentingan.

2. **Demonstrasi dan UAT** — prototipe didemonstrasikan kepada perwakilan Admin, Petugas Klaster, dan Pasien. Responden mengisi kuesioner UAT yang mengukur kemudahan penggunaan, kelengkapan fitur, dan kepuasan keseluruhan. Umpan balik yang diperoleh dirangkum dalam *backlog* perbaikan yang akan ditangani pada iterasi berikutnya.

Dokumentasi setiap evaluasi meliputi: (a) daftar *acceptance criteria* beserta status (lulus/tidak lulus), (b) rekap kuesioner UAT, dan (c) daftar perbaikan yang direncanakan untuk iterasi berikutnya.

## 3.6 Analisis Kebutuhan

### 3.6.1 Kebutuhan Fungsional

Berdasarkan hasil wawancara dan observasi awal, kebutuhan fungsional sistem diidentifikasi per peran sebagai berikut.

**Admin:**
- Mengelola akun pengguna (Petugas Klaster dan Admin lain): buat, ubah, nonaktifkan, hapus.
- Mengonfigurasi layanan, klaster, dan jam operasional.
- Menetapkan aturan prioritas antrian.
- Melihat dan mengekspor laporan analitik.
- Melihat rekapitulasi hasil survei kepuasan pasien dan mengekspor data survei.
- Mengonfigurasi alamat email SMTP penerima notifikasi survei.
- Melakukan backup dan pemulihan data.

**Petugas Klaster:**
- Login ke dasbor petugas.
- Melihat daftar antrian klaster yang aktif.
- Memindai barcode tiket untuk mencatat kedatangan pasien.
- Memanggil nomor antrian berikutnya.
- Memperbarui status tiket (menunggu → dipanggil → dilayani → selesai).
- Mencatat hasil pelayanan dan catatan tambahan.
- Menandai tiket sebagai selesai, yang secara otomatis memicu pengiriman survei kepuasan kepada pasien.

**Pasien:**
- Melakukan registrasi dan menerima tiket dengan nomor unik dan barcode.
- Melihat posisi antrian dan estimasi waktu tunggu.
- Menerima email survei kepuasan otomatis setelah pelayanan selesai.
- Mengisi dan mengirimkan formulir survei kepuasan melalui tautan dalam email.
- Membatalkan atau menjadwal ulang tiket (jika diizinkan oleh kebijakan instansi).

### 3.6.2 Kebutuhan Non-Fungsional

| No. | Kebutuhan | Target |
|---|---|---|
| NF-01 | Waktu respons operasi utama | < [X] detik |
| NF-02 | Ketersediaan sistem | ≥ [X]% uptime per bulan |
| NF-03 | Keamanan autentikasi | Kata sandi di-*hash* (bcrypt); sesi aman |
| NF-04 | Kompatibilitas | Berfungsi di peramban modern (Chrome, Firefox, Safari) |
| NF-05 | Skalabilitas | Mendukung hingga [X] pengguna bersamaan |
| NF-06 | Kemudahan penggunaan | UAT ≥ [X]% responden menyatakan mudah digunakan |

## 3.7 Perancangan Sistem

### 3.7.1 Arsitektur Sistem

Sistem dirancang menggunakan arsitektur *client-server* berbasis web dengan tiga lapisan utama: (1) lapisan presentasi (*front-end*) yang diakses melalui peramban, (2) lapisan logika bisnis (*back-end*) menggunakan Laravel/PHP, dan (3) lapisan data (basis data relasional MySQL/MariaDB).

### 3.7.2 Use Case Diagram

Aktor utama sistem adalah Admin, Petugas Klaster, dan Pasien. Use case utama meliputi: Registrasi Pasien, Penerbitan Tiket & Barcode, Pencatatan Kedatangan melalui Scan, Panggil Nomor, Pembaruan Status Pelayanan, Isi Survei Kepuasan (Pasien via tautan email), dan Pengelolaan Laporan & Hasil Survei (Admin). *(Use Case Diagram disertakan pada Lampiran [X].)*

### 3.7.3 Activity Diagram

Activity diagram memodelkan urutan aktivitas pada skenario kunci, yaitu alur dari registrasi pasien hingga selesainya pelayanan dan pengisian survei kepuasan. Diagram mencakup titik keputusan seperti registrasi online vs. registrasi di loket, validasi barcode saat scan, penanganan pembatalan tiket, serta alur pengiriman dan pengisian survei kepuasan (sistem otomatis mengirim email → pasien membuka tautan → pasien mengisi formulir → sistem menyimpan data dan mengirim notifikasi ke Admin). *(Activity Diagram disertakan pada Lampiran [X].)*

### 3.7.4 Entity Relationship Diagram (ERD)

Entitas utama yang dimodelkan adalah `users`, `patients`, `tickets`, `queue_records`, `services`, `surveys`, dan `logs`. Kardinalitas utama: satu pasien dapat memiliki banyak tiket (1–N), satu tiket memiliki satu queue record (1–1), satu queue record dapat memiliki satu survei kepuasan (1–1), dan satu petugas dapat menangani banyak queue records (1–N). *(ERD disertakan pada Lampiran [X].)*

### 3.7.5 Perancangan Basis Data

Tabel inti dan field utamanya adalah sebagai berikut.

| Tabel | Field Utama |
|---|---|
| `users` | id, username, password_hash, role, name, contact, created_at, updated_at |
| `patients` | id, name, dob, contact, email, created_at |
| `tickets` | id, ticket_no (UNIQUE), barcode (UNIQUE), patient_id (FK), service_id (FK), scheduled_time, status, created_at |
| `queue_records` | id, ticket_id (FK), server_id (FK), arrival_time, called_time, served_time, finish_time, notes |
| `services` | id, name, description, priority, is_active |
| `surveys` | id, queue_record_id (FK), token (UNIQUE), score, comment, email_sent_at, submitted_at, admin_notified_at |
| `logs` | id, user_id (FK), action, resource, timestamp |

Tabel `surveys` menyimpan satu baris per sesi pelayanan yang telah selesai. Field `token` berisi nilai acak yang unik dan hanya dapat digunakan sekali (*single-use*) untuk menjamin bahwa satu tautan survei hanya dapat diisi oleh satu pasien. Field `email_sent_at` mencatat kapan email survei dikirimkan oleh sistem, `submitted_at` mencatat kapan pasien mengisi dan mengirimkan formulir, dan `admin_notified_at` mencatat kapan notifikasi pengiriman hasil survei dikirim ke Admin melalui SMTP.

### 3.7.6 Perancangan Antarmuka

Antarmuka dirancang sesuai peran:

- **Dasbor Admin**: statistik ringkasan, manajemen akun pengguna, konfigurasi layanan, laporan dan ekspor, rekapitulasi hasil survei kepuasan (skor rata-rata, grafik tren, dan komentar pasien), serta konfigurasi alamat email SMTP penerima notifikasi survei.
- **Dasbor Petugas Klaster**: daftar antrian aktif, tombol panggil nomor, antarmuka scan barcode, formulir catatan pelayanan.
- **Halaman Pasien**: formulir registrasi, tampilan tiket/barcode, posisi antrian, estimasi waktu tunggu.
- **Halaman Survei Kepuasan** *(diakses via tautan email)*: formulir penilaian layanan (skala dan pertanyaan terbuka terkait pengalaman menggunakan sistem antrian berbasis barcode), tombol kirim yang memicu pengiriman data ke server dan notifikasi email ke Admin.

Prinsip desain: kontras tinggi untuk keterbacaan di layar publik, responsif untuk perangkat mobile, dan umpan balik visual yang jelas untuk setiap aksi.

## 3.8 Pengujian Sistem

Pengujian sistem dilakukan secara bertahap pada setiap akhir iterasi dan diakhiri dengan UAT final pada Iterasi 3. Jenis pengujian yang diterapkan adalah:

1. **Pengujian Fungsional** — Memverifikasi bahwa setiap fitur bekerja sesuai *acceptance criteria* yang telah ditetapkan.
2. **Pengujian Keamanan** — Memverifikasi bahwa akses lintas peran (*unauthorized access*) tidak dapat dilakukan dan data sensitif tersimpan dengan aman.
3. **Pengujian Kinerja** — Mengukur waktu respons sistem pada skenario beban normal dan beban puncak ([X] pengguna bersamaan).
4. **User Acceptance Testing (UAT)** — Dilakukan bersama [X] Admin, [X] Petugas Klaster, dan [X] Pasien menggunakan kuesioner terstandar. Target tingkat penerimaan ≥ [X]%.

## 3.9 Dokumentasi Penelitian

Seluruh proses penelitian didokumentasikan secara terstruktur untuk menjamin reproducibility dan transparansi. Panduan dokumentasi setiap iterasi adalah sebagai berikut.

### 3.9.1 Dokumen yang Dihasilkan per Iterasi

| Dokumen | Isi Utama | Penanggung Jawab |
|---|---|---|
| Catatan Perencanaan Iterasi | Daftar fitur, jadwal, pembagian tugas | Peneliti |
| Kode Sumber (GitHub) | Perubahan kode, *commit message* terstruktur | Peneliti |
| Laporan Hasil Pengujian | Status *acceptance criteria*, daftar bug | Peneliti |
| Rekap Kuesioner UAT | Skor rata-rata per pertanyaan, komentar kualitatif | Peneliti |
| Backlog Perbaikan | Daftar item perbaikan untuk iterasi berikutnya | Peneliti |

### 3.9.2 Panduan Penulisan Commit

Setiap *commit* kode mengikuti format:

```
[ITER-X] <tipe>: <deskripsi singkat>
```

Contoh:
- `[ITER-1] feat: tambah modul registrasi pasien dan generate barcode`
- `[ITER-2] fix: perbaiki bug pencatatan arrival_time saat koneksi database timeout`
- `[ITER-3] docs: perbarui panduan deployment dan konfigurasi environment`

### 3.9.3 Panduan Penulisan Laporan Hasil Evaluasi

Laporan hasil evaluasi setiap iterasi minimal memuat:

1. Ringkasan fitur yang dikembangkan pada iterasi berjalan.
2. Tabel status *acceptance criteria* (lulus/tidak lulus beserta catatan).
3. Rekapitulasi hasil kuesioner UAT (tabel skor rata-rata per dimensi: *usability*, *functionality*, *reliability*).
4. Temuan utama dan tindak lanjut (masuk ke *backlog* iterasi berikutnya).
5. Perubahan yang dilakukan pasca-evaluasi sebelum iterasi berikutnya dimulai.

## 3.10 Jadwal Penelitian

| Tahap | Kegiatan | Minggu ke- |
|---|---|---|
| Persiapan | Observasi, wawancara awal, kajian literatur | [X]–[X] |
| Desain Konseptual | ERD, wireframe, arsitektur sistem | [X]–[X] |
| **Iterasi 1** | Prototipe inti (autentikasi, tiket, antrian FIFO) | [X]–[X] |
| **Iterasi 2** | Prototipe pengembangan (scan, panggil, notifikasi) | [X]–[X] |
| **Iterasi 3** | Prototipe final (laporan, penyempurnaan, UAT final) | [X]–[X] |
| Dokumentasi | Penulisan laporan dan revisi akhir | [X]–[X] |

---

## Catatan: Bidang yang Perlu Dilengkapi

Berikut adalah daftar placeholder dalam bab ini yang perlu diisi oleh peneliti sebelum finalisasi naskah.

| No. | Lokasi | Keterangan |
|---|---|---|
| 1 | Seluruh `[nama instansi]` | Nama resmi instansi tempat penelitian |
| 2 | Seluruh `[alamat instansi]` | Alamat lengkap instansi |
| 3 | Seluruh `[bulan awal, tahun]` dan `[bulan akhir, tahun]` | Periode penelitian aktual |
| 4 | Tabel 3.3.2 kolom Jumlah Sampel `[X]` | Jumlah sampel yang disepakati dengan instansi |
| 5 | Subbab 3.4 angka `[X] orang` pada setiap teknik | Jumlah responden aktual per teknik |
| 6 | AC-3.4 angka `[X]%` dan `[X]` responden per peran | Target penerimaan UAT dan jumlah responden |
| 7 | AC-3.5 angka `[X] skenario uji` | Jumlah skenario uji yang ditetapkan |
| 8 | AC-3.6 angka `[X] detik` dan `[X] pengguna` | Target waktu respons dan beban pengguna |
| 9 | Tabel NF (Subbab 3.6.2) semua `[X]` | Nilai target non-fungsional |
| 10 | Subbab 3.8 angka responden UAT dan `[X]%` penerimaan | Jumlah peserta UAT dan target penerimaan |
| 11 | Tabel 3.10 kolom Minggu ke- | Nomor minggu aktual sesuai jadwal penelitian |
| 12 | Lampiran `[X]` pada Subbab 3.7.2, 3.7.3, 3.7.4 | Nomor lampiran diagram |
| 13 | Konfigurasi SMTP (`.env`) | Alamat email Admin penerima notifikasi survei, nama driver mail (Mailtrap/Gmail/SendGrid), kredensial SMTP; **jangan di-*commit* ke repositori publik** |
