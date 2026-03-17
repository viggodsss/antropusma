# BAB III
# METODOLOGI PENELITIAN

---

## 3.1 Jenis Penelitian

Penelitian ini termasuk dalam jenis penelitian **Research and Development (R&D)** atau penelitian pengembangan, yaitu suatu proses atau langkah-langkah sistematis untuk mengembangkan suatu produk baru atau menyempurnakan produk yang telah ada. Dalam hal ini, produk yang dikembangkan adalah **Sistem Antrian Berbasis Web dengan Barcode (FIFO)** yang dirancang untuk meningkatkan efisiensi dan akurasi pengelolaan antrian layanan di *[nama instansi/fasilitas layanan — diisi peneliti]*.

Pendekatan yang digunakan dalam penelitian ini adalah **metode campuran** (*mixed methods*), yaitu kombinasi antara:
- **Pendekatan Kualitatif**: digunakan untuk menggali kebutuhan pengguna, memahami proses layanan yang berjalan saat ini, dan mengidentifikasi permasalahan secara mendalam melalui wawancara dan observasi.
- **Pendekatan Kuantitatif**: digunakan untuk mengukur dan membandingkan kinerja sistem secara numerik, seperti rata-rata waktu tunggu, tingkat kesalahan input, dan skor kepuasan pengguna sebelum dan sesudah penerapan sistem.

Kombinasi kedua pendekatan ini dipilih karena penelitian pengembangan sistem informasi umumnya tidak cukup hanya divalidasi secara teknis (*blackbox/whitebox testing*), tetapi juga perlu diukur dampaknya secara empiris terhadap pengguna nyata di lapangan (Aidha Wardhani & Mustika Dewi, 2024).

---

## 3.2 Lokasi dan Waktu Penelitian

**Lokasi Penelitian:**
Penelitian ini dilaksanakan di *[nama instansi/fasilitas layanan — diisi peneliti]*, yang beralamat di *[alamat lengkap instansi — diisi peneliti]*. Pemilihan lokasi ini didasarkan pada pertimbangan bahwa instansi tersebut saat ini masih menggunakan sistem antrian manual yang dinilai kurang efisien dan membutuhkan solusi berbasis teknologi.

**Waktu Penelitian:**
Penelitian ini dilaksanakan selama *[durasi penelitian, contoh: 4 bulan]*, yaitu pada bulan *[bulan mulai]* hingga *[bulan selesai]* tahun *[tahun — diisi peneliti]*. Adapun rincian jadwal pelaksanaan penelitian adalah sebagai berikut:

| No | Kegiatan | Bulan 1 | Bulan 2 | Bulan 3 | Bulan 4 |
|---|---|---|---|---|---|
| 1 | Observasi awal & identifikasi masalah | ✓ | | | |
| 2 | Studi literatur & pengumpulan referensi | ✓ | ✓ | | |
| 3 | Wawancara & pengumpulan data kebutuhan | ✓ | ✓ | | |
| 4 | Analisis kebutuhan & perancangan sistem | | ✓ | | |
| 5 | Pengembangan & implementasi sistem | | ✓ | ✓ | |
| 6 | Pengujian sistem & evaluasi | | | ✓ | |
| 7 | Penyusunan laporan & revisi | | | ✓ | ✓ |

---

## 3.3 Metode Penelitian

Metode penelitian yang digunakan dalam penelitian ini adalah metode pengumpulan data primer dan sekunder yang dikombinasikan untuk memperoleh pemahaman komprehensif tentang sistem antrian yang ada saat ini (*as-is*) dan kebutuhan sistem yang akan dikembangkan (*to-be*).

### 3.3.1 Wawancara

Wawancara (*interview*) dilakukan secara terstruktur dan semi-terstruktur kepada para pemangku kepentingan (*stakeholder*) yang terlibat langsung dalam proses antrian di *[nama instansi — diisi peneliti]*. Tujuan wawancara adalah untuk menggali informasi mendalam mengenai:
- Alur proses antrian yang saat ini berjalan.
- Permasalahan dan kendala yang dihadapi oleh masing-masing peran.
- Ekspektasi dan kebutuhan pengguna terhadap sistem yang akan dikembangkan.
- Fitur-fitur prioritas yang diinginkan.

**Narasumber wawancara:**
1. **Admin** (*[jabatan spesifik — diisi peneliti]*): bertanggung jawab atas pengelolaan keseluruhan sistem dan pelaporan data layanan.
2. **Petugas Klaster** (*[jabatan spesifik — diisi peneliti]*): petugas yang langsung mengelola antrian dan melayani Pasien di masing-masing klaster.
3. **Pasien**: pengguna layanan yang merasakan langsung pengalaman antrian.

Panduan wawancara (*interview guide*) disusun sebelum wawancara dilaksanakan dan divalidasi oleh dosen pembimbing. Hasil wawancara direkam (dengan persetujuan narasumber) dan ditranskripsikan untuk kemudian dianalisis secara tematik.

**Panduan pertanyaan pokok:**
- Bagaimana alur antrian saat ini dari awal hingga Pasien dilayani?
- Berapa rata-rata jumlah Pasien per hari dan berapa lama waktu tunggu rata-rata?
- Apa kendala utama yang dirasakan dalam sistem antrian yang ada?
- Fitur apa yang paling dibutuhkan dalam sistem antrian berbasis web?
- Apakah penggunaan barcode pada tiket antrian dianggap membantu? Mengapa?

### 3.3.2 Observasi

Observasi dilakukan secara **langsung** (*direct observation*) di lokasi penelitian untuk mengamati proses antrian yang sedang berjalan tanpa melakukan intervensi. Kegiatan observasi bertujuan untuk:
- Mendapatkan gambaran nyata tentang alur kerja (*workflow*) antrian sehari-hari.
- Mengukur waktu tunggu rata-rata dan jumlah Pasien yang dilayani per sesi.
- Mengidentifikasi titik-titik kemacetan (*bottleneck*) dan inefisiensi dalam proses antrian.
- Memverifikasi temuan wawancara dengan kondisi lapangan yang sebenarnya.

Observasi dilakukan selama *[jumlah hari/sesi observasi — diisi peneliti]* hari kerja pada jam operasional *[nama instansi — diisi peneliti]*. Hasil observasi dicatat dalam lembar observasi terstruktur yang mencakup: waktu kedatangan Pasien, waktu pemanggilan, waktu selesai layanan, dan catatan kejadian khusus.

### 3.3.3 Studi Literatur

Studi literatur dilakukan untuk membangun landasan teoritis yang kuat bagi penelitian ini. Sumber-sumber yang digunakan meliputi:
- **Buku teks** tentang sistem informasi, analisis dan perancangan sistem, serta rekayasa perangkat lunak.
- **Artikel jurnal ilmiah** yang relevan, khususnya yang membahas sistem antrian berbasis web (Aidha Wardhani & Mustika Dewi, 2024) dan implementasi barcode dalam sistem layanan (Attabarok et al., 2025).
- **Dokumentasi teknis** framework dan teknologi yang digunakan dalam pengembangan sistem.
- **Standar industri** terkait pengkodean barcode (ISO/IEC 18004 untuk QR Code, dll.).
- **Skripsi dan tesis** terdahulu yang memiliki topik serupa sebagai referensi perbandingan.

Studi literatur dilaksanakan sepanjang periode penelitian dan hasilnya dituangkan dalam Bab II (Landasan Teori) serta digunakan sebagai rujukan analitis di seluruh bab.

---

## 3.4 Metode Pengembangan Sistem

Metode pengembangan sistem yang digunakan dalam penelitian ini adalah metode **Prototyping**, yaitu pendekatan pengembangan perangkat lunak yang menekankan pembuatan prototipe (*prototype*) secara cepat dan iteratif berdasarkan umpan balik pengguna. Metode ini dipilih karena:

1. Kebutuhan pengguna terhadap sistem antrian belum sepenuhnya terdefinisi secara formal di awal proyek, sehingga diperlukan proses eksplorasi dan validasi bersama.
2. Prototipe antarmuka sistem dapat ditunjukkan langsung kepada pengguna (Admin, Petugas Klaster, Pasien) untuk mendapatkan masukan konkret sebelum sistem diimplementasikan secara penuh.
3. Metode ini meminimalkan risiko pengembangan karena kesalahan desain dapat terdeteksi dan diperbaiki lebih awal.
4. Waktu pengembangan lebih efisien karena tidak harus menyelesaikan satu fase secara sempurna sebelum melanjutkan ke fase berikutnya.

Sebagai perbandingan, metode **Waterfall** juga dipertimbangkan, namun kurang sesuai untuk penelitian ini karena pendekatan sekuensialnya kurang fleksibel terhadap perubahan kebutuhan yang mungkin muncul selama konsultasi dengan pengguna.

Alur tahapan metode Prototyping yang diterapkan digambarkan sebagai berikut:

```
[Analisis Kebutuhan] → [Perancangan Prototipe] → [Evaluasi Pengguna]
         ↑_______________________________|
                (Iterasi jika perlu)
                        ↓
              [Implementasi Final]
                        ↓
              [Pengujian Sistem]
                        ↓
              [Pemeliharaan]
```

### 3.4.1 Analisis Kebutuhan

Tahap analisis kebutuhan bertujuan untuk mengidentifikasi, mendokumentasikan, dan memvalidasi seluruh kebutuhan fungsional dan non-fungsional dari sistem yang akan dikembangkan.

**Kebutuhan Fungsional** adalah fitur-fitur yang harus dimiliki oleh sistem, di antaranya:
- Manajemen akun pengguna (Admin, Petugas Klaster, Pasien) dengan hak akses berbeda.
- Registrasi antrian online oleh Pasien dengan pembuatan tiket barcode otomatis.
- Pengelolaan antrian FIFO oleh Petugas Klaster, termasuk pemanggilan nomor antrian dan pemindaian barcode.
- Pemantauan status antrian secara *real-time* oleh seluruh peran.
- Pembuatan laporan harian/mingguan/bulanan tentang data layanan oleh Admin.
- Notifikasi kepada Pasien ketika nomor antrian hampir dipanggil.

**Kebutuhan Non-Fungsional** adalah atribut kualitas sistem, meliputi:
- **Ketersediaan** (*availability*): sistem dapat diakses selama jam operasional.
- **Keandalan** (*reliability*): sistem berjalan stabil tanpa gangguan yang signifikan.
- **Keamanan** (*security*): data pengguna terlindungi dengan autentikasi dan enkripsi.
- **Kinerja** (*performance*): halaman memuat dalam waktu kurang dari 3 detik.
- **Kemudahan penggunaan** (*usability*): antarmuka intuitif untuk pengguna dari berbagai latar belakang.

**Identifikasi Pemangku Kepentingan dan Peran:**
| Peran | Tanggung Jawab Utama | Hak Akses |
|---|---|---|
| **Admin** | Mengelola konfigurasi sistem, data pengguna, laporan, dan pengaturan klaster | Akses penuh ke seluruh fitur sistem |
| **Petugas Klaster** | Memanggil nomor antrian, memindai barcode tiket Pasien, mencatat layanan | Akses ke panel antrian klaster yang ditugaskan |
| **Pasien** | Mendaftar antrian, menerima tiket barcode, memantau status antrian | Akses ke formulir pendaftaran dan halaman status antrian |

Hasil analisis kebutuhan didokumentasikan dalam bentuk **Software Requirements Specification (SRS)** dan dijadikan acuan untuk tahap perancangan.

### 3.4.2 Perancangan Kebutuhan

Setelah kebutuhan teridentifikasi dan terdokumentasi, tahap perancangan kebutuhan (*requirements design*) dilakukan untuk mentransformasikan kebutuhan tersebut menjadi spesifikasi desain sistem yang dapat diimplementasikan. Pada tahap ini dilakukan:

- **Pembuatan model proses**: menggambarkan alur kerja sistem dalam bentuk flowchart dan diagram aktivitas.
- **Pembuatan model data**: merancang struktur basis data dalam bentuk Entity Relationship Diagram (ERD) dan skema tabel.
- **Pembuatan model interaksi**: mendefinisikan interaksi antara pengguna dan sistem melalui Use Case Diagram.
- **Perancangan antarmuka awal**: membuat *wireframe* atau *mockup* tampilan antarmuka untuk setiap peran pengguna.

Prototipe awal yang dihasilkan pada tahap ini kemudian dipresentasikan kepada pengguna untuk mendapatkan validasi dan umpan balik.

### 3.4.3 Perancangan Sistem (*Design*)

Tahap perancangan sistem merupakan kelanjutan dari perancangan kebutuhan, di mana desain sistem dikembangkan lebih rinci dan teknis. Pada tahap ini dihasilkan:

- **Arsitektur sistem**: menentukan pola arsitektur aplikasi (misalnya MVC — *Model View Controller*) dan teknologi yang digunakan.
- **Desain basis data final**: struktur tabel, relasi antar-tabel, indeks, dan mekanisme integritas data.
- **Desain antarmuka (*UI Design*)**: tampilan final setiap halaman untuk Admin, Petugas Klaster, dan Pasien.
- **Desain integrasi barcode**: mekanisme pembuatan (*generate*) dan pembacaan (*scan*) barcode dalam alur antrian.
- **Desain alur antrian FIFO**: logika bisnis penentuan urutan antrian berdasarkan timestamp pendaftaran.

### 3.4.4 Implementasi

Tahap implementasi adalah proses penerjemahan desain sistem menjadi kode program yang dapat dijalankan. Kegiatan pada tahap ini meliputi:

- Pembangunan struktur basis data sesuai skema yang telah dirancang.
- Pengkodean modul-modul sistem: autentikasi, manajemen antrian, integrasi barcode, panel Admin, panel Petugas Klaster, dan halaman Pasien.
- Integrasi library atau API untuk pembuatan dan pembacaan barcode/QR Code.
- Pembuatan antarmuka pengguna (*frontend*) sesuai desain UI yang telah disetujui.
- Pengkodean logika FIFO untuk pengelolaan urutan antrian.
- Pengujian awal (*unit testing*) pada setiap modul yang selesai dikembangkan.

Teknologi yang digunakan dalam implementasi: *[diisi peneliti, contoh: Laravel, MySQL, Bootstrap, ZXing/BaconQrCode]*.

### 3.4.5 Pengujian Sistem

Tahap pengujian bertujuan untuk memastikan bahwa sistem berfungsi sesuai dengan kebutuhan yang telah ditetapkan dan bebas dari *bug* atau kesalahan yang signifikan. Jenis pengujian yang dilakukan meliputi:

1. **Pengujian Fungsional** (*Blackbox Testing*): menguji apakah setiap fitur menghasilkan output yang sesuai untuk berbagai skenario input tanpa memperhatikan implementasi internal.
2. **Pengujian Kinerja** (*Performance Testing*): mengukur waktu respons sistem, kapasitas beban, dan stabilitas di bawah kondisi penggunaan normal dan puncak.
3. **Pengujian Kegunaan** (*Usability Testing*): menilai kemudahan penggunaan antarmuka sistem oleh pengguna nyata dari ketiga peran (Admin, Petugas Klaster, Pasien).
4. **Pengujian Kompatibilitas**: memastikan sistem berjalan dengan baik di berbagai browser dan perangkat.

Hasil pengujian sistem didokumentasikan dalam lembar uji dan digunakan sebagai dasar perbaikan sebelum sistem diserahkan kepada pengguna.

### 3.4.6 Pemeliharaan

Tahap pemeliharaan (*maintenance*) dilakukan setelah sistem diimplementasikan dan diserahkan kepada pengguna. Kegiatan pemeliharaan meliputi:

- **Pemeliharaan korektif**: memperbaiki *bug* atau kesalahan yang ditemukan setelah sistem berjalan.
- **Pemeliharaan adaptif**: menyesuaikan sistem dengan perubahan lingkungan teknis (pembaruan server, OS, library).
- **Pemeliharaan perfektif**: meningkatkan fitur atau kinerja sistem berdasarkan masukan pengguna.
- **Pemeliharaan preventif**: melakukan pembaruan dan pengecekan berkala untuk mencegah gangguan di masa mendatang.

Selama periode penelitian, pemeliharaan dilakukan secara terjadwal oleh peneliti bersama Admin *[nama instansi — diisi peneliti]* untuk memastikan sistem berjalan optimal.

---

## 3.5 Perancangan Sistem

Perancangan sistem merupakan tahap di mana konsep dan kebutuhan sistem diterjemahkan menjadi blueprint teknis yang menjadi panduan implementasi. Subbab ini menjabarkan masing-masing artefak perancangan yang dihasilkan.

### 3.5.1 Flowchart Sistem

Flowchart sistem menggambarkan alur kerja keseluruhan sistem antrian dari perspektif proses, termasuk titik keputusan dan percabangan logika. Flowchart dibuat untuk tiga alur utama:

**a. Alur Registrasi Pasien:**
```
[Mulai] → [Pasien buka halaman pendaftaran]
    → [Isi form pendaftaran (nama, keperluan, klaster tujuan)]
    → [Sistem validasi data]
    → [Data valid?]
        → [Tidak] → [Tampilkan pesan error] → [kembali ke form]
        → [Ya] → [Sistem generate nomor antrian + barcode]
              → [Pasien menerima tiket digital]
              → [Sistem simpan data ke database]
              → [Selesai]
```

**b. Alur Pemanggilan Antrian oleh Petugas Klaster:**
```
[Mulai] → [Petugas login ke sistem]
    → [Tampilkan daftar antrian klaster (urut FIFO)]
    → [Petugas pilih "Panggil berikutnya"]
    → [Sistem tampilkan nomor antrian + nama Pasien]
    → [Pasien hadir?]
        → [Tidak] → [Pasien di-skip / ditandai tidak hadir]
        → [Ya] → [Petugas pindai barcode tiket Pasien]
              → [Sistem verifikasi barcode]
              → [Barcode valid?]
                  → [Tidak] → [Tampilkan pesan invalid]
                  → [Ya] → [Status antrian diperbarui: "Sedang Dilayani"]
                         → [Pelayanan berlangsung]
                         → [Petugas tandai "Selesai"]
                         → [Sistem catat waktu selesai]
                         → [Selesai]
```

**c. Alur Pemantauan oleh Admin:**
```
[Mulai] → [Admin login ke sistem]
    → [Dashboard: ringkasan antrian & statistik]
    → [Admin pilih menu]
        → [Manajemen Pengguna] → [Tambah/Edit/Hapus akun Admin/Petugas/Pasien]
        → [Laporan] → [Generate laporan per periode]
        → [Pengaturan] → [Konfigurasi klaster, jam operasional]
    → [Selesai]
```

### 3.5.2 Use Case Diagram

Use Case Diagram menggambarkan interaksi antara pengguna (*actor*) dengan fungsionalitas sistem. Berikut adalah use case utama untuk masing-masing peran:

**Aktor:**
- **Admin**: pengelola sistem tingkat tertinggi.
- **Petugas Klaster**: operator antrian di klaster layanan.
- **Pasien**: pengguna layanan yang menggunakan antrian.

**Use Case Utama:**

| Aktor | Use Case |
|---|---|
| Pasien | Mendaftar akun, Login, Mengambil nomor antrian, Melihat status antrian, Mengunduh/mencetak tiket barcode |
| Petugas Klaster | Login, Melihat daftar antrian klaster, Memanggil nomor antrian berikutnya, Memindai barcode tiket, Menandai layanan selesai, Menandai Pasien tidak hadir |
| Admin | Login, Mengelola akun pengguna, Mengelola konfigurasi klaster, Memantau semua antrian, Melihat dan mengunduh laporan |
| Sistem | Menghasilkan nomor antrian (FIFO), Menghasilkan barcode unik, Memperbarui status antrian *real-time*, Mengirimkan notifikasi |

### 3.5.3 Activity Diagram

Activity Diagram menggambarkan alur aktivitas secara rinci dari perspektif masing-masing aktor. Diagram ini melengkapi Use Case Diagram dengan menampilkan urutan aktivitas, percabangan keputusan, dan aktivitas paralel.

**Activity Diagram Proses Antrian Lengkap:**

```
[Pasien: Buka Sistem]
        ↓
[Pasien: Isi Form Pendaftaran]
        ↓
[Sistem: Validasi & Generate Nomor Antrian + Barcode]
        ↓
[Pasien: Terima Tiket Barcode Digital]
        ↓
[Pasien: Menunggu Panggilan]
        ↓                              ↓
[Sistem: Kirim Notifikasi "Segera Dipanggil"]
        ↓
[Petugas: Panggil Nomor Antrian]
        ↓
[Pasien: Menuju Loket]
        ↓
[Petugas: Pindai Barcode Tiket]
        ↓
[Sistem: Verifikasi & Update Status "Sedang Dilayani"]
        ↓
[Petugas: Berikan Layanan]
        ↓
[Petugas: Tandai Selesai]
        ↓
[Sistem: Update Status "Selesai" + Catat Timestamp]
        ↓
[Sistem: Perbarui Antrian FIFO]
```

### 3.5.4 Entity Relationship Diagram (ERD)

ERD menggambarkan struktur data dan relasi antar-entitas dalam sistem. Entitas-entitas utama dalam sistem antrian berbasis web ini adalah:

**Entitas Utama:**
1. **users**: menyimpan data semua pengguna sistem (Admin, Petugas Klaster, Pasien) dengan atribut `id`, `nama`, `email`, `password`, `role`, `created_at`, `updated_at`.
2. **clusters**: menyimpan data klaster layanan dengan atribut `id`, `nama_klaster`, `deskripsi`, `status_aktif`, `created_at`.
3. **queues**: menyimpan data antrian dengan atribut `id`, `pasien_id`, `cluster_id`, `nomor_antrian`, `barcode_token`, `status` (menunggu/dipanggil/dilayani/selesai/tidak_hadir), `waktu_daftar`, `waktu_panggil`, `waktu_selesai`.
4. **service_logs**: menyimpan log layanan dengan atribut `id`, `queue_id`, `petugas_id`, `catatan`, `created_at`.

**Relasi Antar-Entitas:**
- `users` ↔ `queues`: satu Pasien dapat memiliki banyak antrian (one-to-many).
- `clusters` ↔ `queues`: satu klaster dapat memiliki banyak antrian (one-to-many).
- `users` (Petugas) ↔ `service_logs`: satu Petugas dapat mencatat banyak log layanan (one-to-many).
- `queues` ↔ `service_logs`: satu antrian memiliki satu log layanan (one-to-one).

### 3.5.5 Perancangan Database

Perancangan basis data mengacu pada ERD yang telah dibuat. Berikut adalah spesifikasi tabel-tabel utama dalam sistem:

**Tabel `users`:**
| Field | Tipe Data | Keterangan |
|---|---|---|
| id | INT (PK, AI) | Primary key |
| nama | VARCHAR(100) | Nama lengkap pengguna |
| email | VARCHAR(100) UNIQUE | Email untuk login |
| password | VARCHAR(255) | Password terenkripsi (bcrypt) |
| role | ENUM('admin','petugas','pasien') | Peran pengguna |
| created_at | TIMESTAMP | Waktu akun dibuat |
| updated_at | TIMESTAMP | Waktu terakhir diperbarui |

**Tabel `clusters`:**
| Field | Tipe Data | Keterangan |
|---|---|---|
| id | INT (PK, AI) | Primary key |
| nama_klaster | VARCHAR(100) | Nama klaster layanan |
| deskripsi | TEXT | Keterangan jenis layanan |
| status_aktif | TINYINT(1) | 1 = aktif, 0 = nonaktif |
| created_at | TIMESTAMP | Waktu data dibuat |

**Tabel `queues`:**
| Field | Tipe Data | Keterangan |
|---|---|---|
| id | INT (PK, AI) | Primary key |
| pasien_id | INT (FK → users.id) | ID Pasien yang mendaftar |
| cluster_id | INT (FK → clusters.id) | ID Klaster tujuan |
| nomor_antrian | INT | Nomor antrian berurutan per klaster per hari |
| barcode_token | VARCHAR(255) UNIQUE | Token unik untuk barcode |
| status | ENUM('menunggu','dipanggil','dilayani','selesai','tidak_hadir') | Status antrian saat ini |
| waktu_daftar | TIMESTAMP | Waktu Pasien mendaftar (dasar FIFO) |
| waktu_panggil | TIMESTAMP NULL | Waktu Pasien dipanggil |
| waktu_selesai | TIMESTAMP NULL | Waktu layanan selesai |

**Tabel `service_logs`:**
| Field | Tipe Data | Keterangan |
|---|---|---|
| id | INT (PK, AI) | Primary key |
| queue_id | INT (FK → queues.id) | ID antrian yang dilayani |
| petugas_id | INT (FK → users.id) | ID Petugas Klaster yang melayani |
| catatan | TEXT NULL | Catatan tambahan layanan |
| created_at | TIMESTAMP | Waktu log dicatat |

### 3.5.6 Perancangan Antarmuka Sistem

Perancangan antarmuka (*User Interface/UI*) dibuat dalam bentuk *wireframe* yang menggambarkan tata letak dan elemen-elemen utama setiap halaman. Prinsip desain yang diterapkan mengutamakan **kemudahan penggunaan** (*usability*), **konsistensi visual**, dan **aksesibilitas** di berbagai ukuran layar (*responsive design*).

**Halaman-halaman utama yang dirancang:**

**Untuk Pasien:**
1. **Halaman Beranda/Landing**: penjelasan singkat layanan dan tombol "Daftar Antrian" serta "Cek Status Antrian".
2. **Halaman Pendaftaran Antrian**: form sederhana berisi: nama, pilihan klaster, dan keperluan.
3. **Halaman Tiket Antrian**: menampilkan nomor antrian, barcode/QR Code tiket, nama Pasien, klaster tujuan, waktu daftar, dan estimasi waktu tunggu.
4. **Halaman Status Antrian**: menampilkan posisi antrian saat ini (*real-time*) beserta nomor yang sedang dipanggil.

**Untuk Petugas Klaster:**
1. **Halaman Login**: form autentikasi email dan password.
2. **Dashboard Petugas**: daftar antrian klaster yang ditugaskan, nomor yang sedang dilayani, dan tombol "Panggil Berikutnya".
3. **Halaman Pindai Barcode**: antarmuka pemindaian barcode (kamera atau input manual token).
4. **Halaman Riwayat Layanan**: daftar Pasien yang telah dilayani pada sesi hari ini.

**Untuk Admin:**
1. **Halaman Login**: form autentikasi dengan proteksi akses admin.
2. **Dashboard Admin**: ringkasan statistik: total antrian hari ini, rata-rata waktu tunggu, jumlah Pasien per klaster.
3. **Halaman Manajemen Pengguna**: tabel daftar semua pengguna dengan fitur tambah, edit, hapus, dan ubah peran.
4. **Halaman Manajemen Klaster**: pengaturan klaster layanan (tambah, edit, aktifkan/nonaktifkan).
5. **Halaman Laporan**: pilihan periode (harian, mingguan, bulanan) dan ekspor ke format PDF/Excel.

---

## 3.6 Alur Sistem Antrian

Subbab ini mendeskripsikan alur kerja sistem antrian secara lengkap, memetakan setiap aksi yang dilakukan oleh masing-masing peran (Admin, Petugas Klaster, Pasien) beserta respons sistem dan pencatatan *timestamp* pada setiap tahap.

**Deskripsi lengkap alur sistem antrian:**

### Langkah 1: Pasien Melakukan Registrasi Antrian

**Aktor:** Pasien  
**Aksi:**
1. Pasien membuka aplikasi web sistem antrian melalui browser (komputer atau smartphone).
2. Pasien mengklik tombol "Ambil Nomor Antrian" atau "Daftar Sekarang".
3. Pasien mengisi formulir pendaftaran dengan informasi yang dibutuhkan:
   - Nama lengkap
   - Nomor identitas (*[disesuaikan dengan kebijakan instansi — diisi peneliti]*)
   - Keperluan / jenis layanan yang dibutuhkan
   - Pilihan klaster tujuan
4. Pasien mengklik tombol "Daftar / Ambil Antrian".

**Respons Sistem:**
- Sistem memvalidasi kelengkapan dan kebenaran data yang diisi.
- Sistem menentukan nomor antrian berdasarkan prinsip **FIFO**: nomor diberikan secara berurutan berdasarkan waktu pendaftaran (*timestamp* `waktu_daftar`), dimulai dari nomor 1 setiap hari untuk setiap klaster.
- Sistem menghasilkan **token barcode unik** yang dihubungkan dengan data antrian Pasien.
- Sistem menyimpan data antrian ke tabel `queues` dengan status awal `menunggu`.
- Sistem menampilkan halaman tiket antrian yang memuat: nomor antrian, QR Code/barcode tiket, nama Pasien, klaster tujuan, tanggal & waktu daftar, dan estimasi posisi antrian.

**Timestamp dicatat:** `queues.waktu_daftar` = waktu saat Pasien berhasil mendaftar.

---

### Langkah 2: Pasien Menunggu dan Memantau Status Antrian

**Aktor:** Pasien  
**Aksi:**
1. Pasien menyimpan atau mencetak tiket barcode yang diterima.
2. Pasien dapat memantau status antrian secara *real-time* melalui halaman "Status Antrian" yang menampilkan nomor antrian yang sedang dipanggil dan posisi Pasien dalam antrean.
3. Sistem mengirimkan notifikasi kepada Pasien ketika nomor antrian hampir tiba (misalnya: "Anda adalah 3 nomor berikutnya").

---

### Langkah 3: Petugas Klaster Mempersiapkan Layanan

**Aktor:** Petugas Klaster  
**Aksi:**
1. Petugas Klaster login ke sistem menggunakan akun yang telah disiapkan oleh Admin.
2. Petugas membuka dashboard antrian klaster yang ditugaskan.
3. Dashboard menampilkan daftar antrian yang sedang menunggu, diurutkan berdasarkan `waktu_daftar` (FIFO) — dari nomor terkecil ke terbesar.

---

### Langkah 4: Petugas Klaster Memanggil Nomor Antrian

**Aktor:** Petugas Klaster  
**Aksi:**
1. Petugas mengklik tombol **"Panggil Berikutnya"** pada sistem.
2. Sistem secara otomatis memanggil antrian berikutnya berdasarkan urutan FIFO (Pasien dengan `waktu_daftar` paling awal yang belum dilayani).
3. Nomor antrian dan nama Pasien yang dipanggil ditampilkan di dashboard Petugas dan di layar antrian publik (jika tersedia).

**Respons Sistem:**
- Status antrian Pasien diperbarui dari `menunggu` menjadi `dipanggil`.
- **Timestamp dicatat:** `queues.waktu_panggil` = waktu saat Petugas mengklik "Panggil Berikutnya".

---

### Langkah 5: Verifikasi Barcode Tiket Pasien

**Aktor:** Petugas Klaster  
**Aksi:**
1. Pasien yang dipanggil menuju loket/meja Petugas Klaster.
2. Pasien menunjukkan tiket barcode (digital di smartphone atau cetak).
3. Petugas memindai barcode tiket menggunakan *scanner* atau kamera perangkat.

**Respons Sistem:**
- Sistem membaca token barcode dan memverifikasi kesesuaiannya dengan nomor antrian yang dipanggil.
- Jika **valid**: sistem memperbarui status antrian menjadi `dilayani` dan menampilkan konfirmasi kepada Petugas.
- Jika **tidak valid**: sistem menampilkan pesan kesalahan dan meminta Petugas untuk memeriksa ulang.

---

### Langkah 6: Proses Pemberian Layanan

**Aktor:** Petugas Klaster  
**Aksi:**
1. Petugas memberikan layanan kepada Pasien sesuai keperluan yang didaftarkan.
2. Selama proses layanan berlangsung, status antrian Pasien tetap tercatat sebagai `dilayani`.

---

### Langkah 7: Penyelesaian Layanan

**Aktor:** Petugas Klaster  
**Aksi:**
1. Setelah layanan selesai, Petugas mengklik tombol **"Selesai"** pada sistem.
2. Petugas dapat menambahkan catatan layanan jika diperlukan.

**Respons Sistem:**
- Status antrian Pasien diperbarui menjadi `selesai`.
- **Timestamp dicatat:** `queues.waktu_selesai` = waktu saat Petugas menandai layanan selesai.
- Sistem mencatat entri baru di tabel `service_logs` dengan referensi ke `queue_id` dan `petugas_id`.
- Sistem secara otomatis memperbarui daftar antrian dan menampilkan nomor antrian berikutnya yang siap dipanggil.

---

### Langkah 8: Pemantauan dan Pelaporan oleh Admin

**Aktor:** Admin  
**Aksi:**
1. Admin dapat memantau seluruh proses antrian di semua klaster secara *real-time* melalui dashboard Admin.
2. Admin dapat melihat statistik kinerja: jumlah Pasien dilayani, rata-rata waktu tunggu (selisih `waktu_panggil` - `waktu_daftar`), rata-rata waktu layanan (selisih `waktu_selesai` - `waktu_panggil`).
3. Admin dapat menghasilkan laporan periode tertentu dan mengekspornya dalam format yang dapat dibagikan.

**Perhitungan metrik kinerja oleh sistem:**
- **Rata-rata waktu tunggu** = rata-rata (`waktu_panggil` - `waktu_daftar`) untuk semua antrian terpanggil pada periode tertentu.
- **Rata-rata waktu layanan** = rata-rata (`waktu_selesai` - `waktu_panggil`) untuk semua antrian selesai.
- **Throughput** = jumlah Pasien dilayani per jam / per hari.
- **Tingkat kehadiran** = jumlah Pasien hadir / jumlah Pasien terdaftar × 100%.

---

### Evaluasi dan Pengujian Statistik

Untuk mengukur efektivitas sistem yang dikembangkan, dilakukan perbandingan antara kondisi sebelum dan sesudah penerapan sistem (*pre-test vs. post-test*) dengan menggunakan:

1. **Uji-t berpasangan** (*paired t-test*): digunakan untuk membandingkan rata-rata waktu tunggu sebelum dan sesudah penerapan sistem, apabila data berdistribusi normal.
2. **Uji Wilcoxon** (*Wilcoxon signed-rank test*): digunakan sebagai alternatif non-parametrik apabila asumsi normalitas tidak terpenuhi.

**Hipotesis uji:**
- H₀: Tidak terdapat perbedaan signifikan rata-rata waktu tunggu sebelum dan sesudah penerapan sistem antrian berbasis web.
- H₁: Terdapat perbedaan signifikan rata-rata waktu tunggu sebelum dan sesudah penerapan sistem antrian berbasis web.
- Tingkat signifikansi: α = 0,05.

**Instrumen penilaian kepuasan pengguna:**
- Kuesioner berbasis skala Likert 1–5 yang diberikan kepada *[jumlah responden — diisi peneliti]* responden dari kelompok Pasien dan Petugas Klaster.
- Uji **validitas**: menggunakan korelasi Pearson (*r*-tabel) untuk memastikan setiap butir pertanyaan mengukur apa yang seharusnya diukur.
- Uji **reliabilitas**: menggunakan koefisien Alpha Cronbach (α ≥ 0,6 dianggap reliabel).

**Pertimbangan etis penelitian:**
- Seluruh narasumber wawancara dan responden kuesioner memberikan persetujuan (*informed consent*) sebelum berpartisipasi.
- Data pribadi Pasien yang digunakan dalam pengembangan dan pengujian sistem dianonimkan atau menggunakan data fiktif sesuai kebijakan etika penelitian institusi.
- Penelitian ini tidak memengaruhi pelayanan nyata kepada Pasien selama fase pengujian sistem.

---

## Apa yang Perlu Dilengkapi

Berikut adalah daftar item yang **wajib diisi oleh peneliti** sebelum dokumen ini dapat digunakan sebagai bagian final dari skripsi:

1. **Nama instansi/fasilitas layanan**: ganti semua teks *[nama instansi/fasilitas layanan — diisi peneliti]* dengan nama resmi instansi tempat penelitian dilaksanakan.
2. **Alamat instansi**: lengkapi teks *[alamat lengkap instansi — diisi peneliti]* dengan alamat lengkap dan resmi.
3. **Periode penelitian**: isi *[durasi penelitian]*, *[bulan mulai]*, *[bulan selesai]*, dan *[tahun]* dengan jadwal yang sebenarnya.
4. **Jumlah sampel/responden**: isi *[jumlah responden — diisi peneliti]* dengan jumlah sampel aktual yang ditentukan berdasarkan perhitungan sampel (misalnya rumus Slovin) atau pertimbangan peneliti.
5. **Teknologi yang dipilih**: isi *[diisi peneliti, contoh: Laravel, MySQL, Bootstrap, ZXing/BaconQrCode]* dengan stack teknologi yang benar-benar digunakan.
6. **Jabatan spesifik narasumber**: lengkapi *[jabatan spesifik — diisi peneliti]* dengan jabatan resmi Admin dan Petugas Klaster di instansi.
7. **Jumlah hari observasi**: isi *[jumlah hari/sesi observasi — diisi peneliti]* dengan jumlah aktual.
8. **Nomor identitas Pasien**: sesuaikan *[disesuaikan dengan kebijakan instansi — diisi peneliti]* dengan jenis identitas yang diminta (NIK, nomor rekam medis, dll.).
9. **Referensi lengkap**: lengkapi tabel "Penelitian Terdahulu" di Bab II dengan minimal 3–5 referensi tambahan selain dua referensi utama yang telah disertakan.
10. **Judul lengkap dan detail bibliografi** referensi Aidha Wardhani & Mustika Dewi (2024) dan Attabarok et al. (2025) di daftar pustaka.

---

### Daftar Referensi Bab III

- Aidha Wardhani, & Mustika Dewi. (2024). *[Judul lengkap artikel — diisi peneliti]*. *[Nama Jurnal]*, *[Volume]*(Nomor), halaman. DOI/URL.
- Attabarok, *et al.* (2025). *[Judul lengkap artikel — diisi peneliti]*. *[Nama Jurnal]*, *[Volume]*(Nomor), halaman. DOI/URL.
