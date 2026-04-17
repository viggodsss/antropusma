# BAB III
# METODOLOGI PENELITIAN

---

## 3.1 Jenis Penelitian

Penelitian ini termasuk dalam kategori penelitian dan pengembangan (*Research and Development* / R&D) dengan pendekatan metode campuran (*mixed methods*), yaitu kombinasi antara pendekatan kualitatif dan kuantitatif. Pendekatan kualitatif digunakan dalam tahap analisis kebutuhan, di mana data dikumpulkan melalui wawancara mendalam dan observasi langsung untuk memahami permasalahan dan kebutuhan nyata pengguna. Sementara itu, pendekatan kuantitatif digunakan dalam tahap evaluasi dan pengujian sistem, di mana data terukur dikumpulkan melalui kuesioner dan pengukuran performa sistem untuk menilai efektivitas dan efisiensi sistem yang dikembangkan.

Tujuan utama penelitian R&D adalah menghasilkan sebuah produk—dalam hal ini sistem antrian berbasis web dengan barcode—yang telah melalui proses desain, pengembangan, dan validasi secara sistematis. Produk yang dihasilkan bukan sekadar prototipe konseptual, melainkan sistem yang telah diuji dan siap digunakan secara nyata di lingkungan **[nama instansi — harap dilengkapi]**.

Dengan pendekatan mixed methods, peneliti dapat memperoleh pemahaman yang lebih holistik: data kualitatif memberikan kedalaman pemahaman tentang kebutuhan dan pengalaman pengguna, sedangkan data kuantitatif memberikan bukti empiris tentang efektivitas sistem secara terukur.

---

## 3.2 Lokasi dan Waktu Penelitian

Penelitian ini dilaksanakan di **[nama instansi/klinik/rumah sakit — harap dilengkapi]**, yang beralamat di **[alamat lengkap instansi — harap dilengkapi]**. Instansi tersebut dipilih sebagai lokasi penelitian karena **[alasan pemilihan lokasi — harap dilengkapi, misalnya: volume antrian yang tinggi, proses antrian yang masih manual, kesediaan pihak instansi untuk berpartisipasi dalam penelitian, dll.]**.

Penelitian dilaksanakan pada periode **[bulan awal] — [bulan akhir] [tahun]**. Rincian jadwal kegiatan penelitian adalah sebagai berikut:

| No. | Kegiatan                        | Bulan ke-1 | Bulan ke-2 | Bulan ke-3 | Bulan ke-4 | Bulan ke-5 |
|-----|---------------------------------|:----------:|:----------:|:----------:|:----------:|:----------:|
| 1   | Studi Pendahuluan & Literatur   | ✓          |            |            |            |            |
| 2   | Analisis Kebutuhan              | ✓          | ✓          |            |            |            |
| 3   | Perancangan Sistem              |            | ✓          | ✓          |            |            |
| 4   | Implementasi (Pengkodean)       |            |            | ✓          | ✓          |            |
| 5   | Pengujian Sistem                |            |            |            | ✓          |            |
| 6   | Evaluasi & Revisi               |            |            |            | ✓          | ✓          |
| 7   | Penyusunan Laporan              |            |            |            |            | ✓          |

*Catatan: Tabel jadwal di atas bersifat indikatif. Sesuaikan dengan jadwal nyata penelitian Anda.*

---

## 3.3 Metode Pengumpulan Data

Pengumpulan data dalam penelitian ini dilakukan menggunakan tiga metode utama yang saling melengkapi, yaitu wawancara, observasi, dan studi literatur. Kombinasi ketiga metode ini bertujuan untuk memastikan bahwa data yang dikumpulkan bersifat komprehensif, akurat, dan relevan dengan kebutuhan pengembangan sistem.

**Pemangku Kepentingan (*Stakeholders*) dan Peran:**

Terdapat tiga kelompok pengguna (peran) yang menjadi subjek dalam penelitian ini:

| Peran             | Deskripsi                                                                                     |
|-------------------|-----------------------------------------------------------------------------------------------|
| **Admin**         | Pengelola sistem secara keseluruhan; memiliki akses penuh untuk konfigurasi klaster, manajemen pengguna, dan pemantauan laporan. |
| **Petugas Klaster** | Petugas yang bertanggung jawab memanggil nomor antrian, memverifikasi kedatangan pasien melalui barcode, dan mengelola layanan di klaster tertentu. |
| **Pasien**        | Pengguna akhir layanan yang melakukan registrasi antrian, memperoleh tiket barcode, dan mengikuti proses antrian hingga mendapatkan layanan. |

### 3.3.1 Wawancara

Wawancara dilakukan secara semi-terstruktur (*semi-structured interview*) terhadap perwakilan dari masing-masing kelompok pengguna. Tujuannya adalah untuk menggali informasi mendalam tentang kondisi proses antrian yang berjalan saat ini, permasalahan yang dihadapi, kebutuhan dan harapan terhadap sistem baru, serta preferensi antarmuka dan alur kerja.

**Panduan umum wawancara:**
- *Admin*: pertanyaan difokuskan pada proses manajemen antrian saat ini, pelaporan, dan kebutuhan konfigurasi sistem.
- *Petugas Klaster*: pertanyaan difokuskan pada alur kerja pelayanan, hambatan dalam proses pemanggilan antrian, dan pengalaman dengan teknologi barcode.
- *Pasien*: pertanyaan difokuskan pada pengalaman menunggu, preferensi sistem antrian, dan kenyamanan penggunaan tiket barcode.

**Jumlah informan**: **[harap isi jumlah informan untuk setiap kelompok, misal: 2 Admin, 3 Petugas Klaster, 10 Pasien]**.

Hasil wawancara direkam (dengan persetujuan informan), ditranskripsikan, dan dianalisis secara tematik untuk mengidentifikasi kebutuhan fungsional dan non-fungsional sistem.

### 3.3.2 Observasi

Observasi dilakukan secara langsung di lingkungan **[nama instansi]** untuk mengamati proses antrian yang berjalan saat ini. Metode observasi yang digunakan adalah observasi non-partisipatif, di mana peneliti berperan sebagai pengamat tanpa terlibat langsung dalam proses layanan.

Aspek-aspek yang diamati meliputi:
- Alur kedatangan dan registrasi pasien.
- Mekanisme pemberian nomor antrian saat ini.
- Proses pemanggilan pasien dan verifikasi kehadiran.
- Waktu tunggu rata-rata dari kedatangan hingga dilayani.
- Potensi hambatan dan kemacetan (*bottleneck*) dalam proses antrian.
- Infrastruktur teknologi yang sudah tersedia (komputer, printer, jaringan, dll.).

Hasil observasi didokumentasikan dalam lembar observasi terstruktur dan foto/rekaman visual (jika diizinkan oleh pihak instansi).

### 3.3.3 Studi Literatur

Studi literatur dilakukan untuk membangun landasan teori yang kuat dan memahami penelitian-penelitian terdahulu yang relevan. Sumber literatur yang digunakan mencakup:

- Buku teks tentang sistem informasi, rekayasa perangkat lunak, dan manajemen antrian.
- Artikel jurnal ilmiah nasional dan internasional, termasuk penelitian Aidha Wardhani & Mustika Dewi (2024) dan Attabarok et al. (2025).
- Standar dan dokumentasi teknis terkait teknologi barcode, pengembangan web, dan manajemen basis data.
- Skripsi dan tesis dari penelitian sejenis yang relevan.

Literatur dikumpulkan dari basis data akademik seperti Google Scholar, SINTA, dan perpustakaan digital perguruan tinggi, dengan periode publikasi yang diprioritaskan dalam **10 tahun terakhir** untuk memastikan relevansi dan kebaruan informasi.

---

## 3.4 Metode Pengembangan Sistem

Metode pengembangan sistem yang digunakan dalam penelitian ini adalah **Prototyping**. Metode ini dipilih berdasarkan pertimbangan berikut:

1. **Ketidakpastian Kebutuhan Awal**: pada tahap awal penelitian, spesifikasi kebutuhan pengguna belum sepenuhnya dapat didefinisikan secara lengkap, sehingga diperlukan pendekatan iteratif yang memungkinkan penyempurnaan bertahap.
2. **Keterlibatan Pengguna Tinggi**: metode Prototyping mendorong keterlibatan aktif pengguna (Admin, Petugas Klaster, Pasien) dalam proses evaluasi, sehingga produk akhir lebih sesuai dengan kebutuhan nyata.
3. **Efisiensi Waktu**: prototipe yang dapat didemonstrasikan lebih awal memberikan umpan balik yang lebih konkret dibandingkan dokumen spesifikasi, sehingga revisi dapat dilakukan lebih efisien.
4. **Pengurangan Risiko**: dengan mendeteksi ketidaksesuaian lebih awal melalui evaluasi prototipe, risiko pengerjaan ulang di tahap akhir dapat diminimalkan.

Sebagai perbandingan, metode **Waterfall** juga dipertimbangkan namun tidak dipilih karena sifatnya yang sekuensial dan kurang fleksibel terhadap perubahan kebutuhan yang mungkin muncul seiring berlangsungnya penelitian. Sementara itu, metode **Agile/Scrum** dianggap terlalu kompleks untuk skala proyek skripsi dengan sumber daya yang terbatas.

Tahapan dalam metode Prototyping yang diterapkan pada penelitian ini adalah sebagai berikut:

### 3.4.1 Analisis Kebutuhan

Tahap analisis kebutuhan merupakan langkah fundamental yang menentukan arah seluruh proses pengembangan. Pada tahap ini, peneliti melakukan:

- **Pengumpulan kebutuhan fungsional**: fitur-fitur yang harus ada dalam sistem, misalnya: registrasi pasien, pembuatan tiket barcode, pemanggilan antrian, verifikasi barcode, pemantauan *real-time*, dan pelaporan.
- **Pengumpulan kebutuhan non-fungsional**: karakteristik kualitas sistem seperti performa, keamanan, kemudahan penggunaan (*usability*), dan keandalan (*reliability*).
- **Identifikasi peran pengguna**: mendefinisikan hak akses dan fungsionalitas yang tersedia bagi setiap peran (Admin, Petugas Klaster, Pasien).
- **Penyusunan dokumen kebutuhan**: hasil analisis didokumentasikan dalam Spesifikasi Kebutuhan Perangkat Lunak (SKPL) sebagai acuan pengembangan.

Pada penelitian ini, analisis kebutuhan dilakukan melalui kombinasi wawancara, observasi, dan kajian sistem antrian yang sudah ada, sehingga diperoleh gambaran komprehensif tentang apa yang dibutuhkan oleh **[nama instansi]** dari sistem baru ini.

### 3.4.2 Perancangan Kebutuhan

Berdasarkan hasil analisis kebutuhan, dilakukan perancangan konseptual yang memetakan setiap kebutuhan ke dalam komponen-komponen desain sistem. Pada tahap ini, peneliti mendefinisikan:

- **Arsitektur sistem**: hubungan antara *front-end*, *back-end*, dan basis data.
- **Model data**: entitas dan hubungan antara data yang akan dikelola sistem.
- **Alur proses bisnis**: diagram alir yang menggambarkan prosedur operasional sistem, termasuk proses registrasi, pemanggilan antrian, dan verifikasi barcode.
- **Antarmuka pengguna (konseptual)**: sketsa awal tampilan untuk setiap peran pengguna.

Dokumen perancangan kebutuhan ini menjadi dasar bagi pembuatan prototipe pertama sistem.

### 3.4.3 Perancangan Sistem (*Design*)

Tahap perancangan sistem menghasilkan blueprint teknis yang lebih rinci, meliputi:

- **Perancangan antarmuka pengguna (*UI/UX*)**: *wireframe* dan *mockup* untuk setiap halaman aplikasi.
- **Perancangan basis data**: skema ERD, struktur tabel, dan relasi antartabel.
- **Perancangan alur sistem**: *flowchart* sistem secara menyeluruh, *use case diagram*, dan *activity diagram*.
- **Perancangan integrasi barcode**: mekanisme pembuatan, penyimpanan, dan pembacaan barcode dalam sistem.

Detail perancangan sistem diuraikan lebih lanjut dalam Subbab 3.5.

### 3.4.4 Implementasi

Tahap implementasi adalah proses penulisan kode program (*coding*) berdasarkan desain yang telah ditetapkan. Kegiatan pada tahap ini meliputi:

- Pengembangan *back-end*: membangun logika bisnis, API, dan manajemen basis data menggunakan **[framework/teknologi yang dipilih — harap dilengkapi, misalnya: Laravel, CodeIgniter, dll.]**.
- Pengembangan *front-end*: membangun antarmuka pengguna yang responsif menggunakan **[teknologi front-end yang dipilih — harap dilengkapi, misalnya: Bootstrap, Tailwind CSS, Vue.js, dll.]**.
- Integrasi barcode: mengimplementasikan modul pembuatan dan pembacaan barcode ke dalam alur sistem antrian.
- Manajemen basis data: membuat dan mengkonfigurasi basis data **[DBMS yang dipilih — harap dilengkapi, misalnya: MySQL, PostgreSQL, dll.]** sesuai dengan skema yang telah dirancang.

Proses implementasi dilakukan secara bertahap mengikuti iterasi metode Prototyping, sehingga setiap modul dapat diuji secara terpisah sebelum diintegrasikan.

### 3.4.5 Pengujian Sistem

Pengujian sistem dilakukan untuk memverifikasi bahwa sistem yang dibangun berfungsi sesuai dengan spesifikasi yang telah ditetapkan dan memenuhi kebutuhan pengguna. Metode pengujian yang digunakan meliputi:

- **Pengujian Fungsional (*Black-Box Testing*)**: menguji setiap fitur sistem dari perspektif pengguna, memverifikasi bahwa *input* tertentu menghasilkan *output* yang sesuai.
- **Pengujian Integrasi**: memastikan bahwa seluruh modul sistem (pendaftaran, barcode, antrian, pelaporan) bekerja secara harmonis.
- **Pengujian Penerimaan Pengguna (*User Acceptance Testing*/UAT)**: melibatkan pengguna nyata dari setiap kelompok (Admin, Petugas Klaster, Pasien) untuk menguji sistem dalam kondisi mendekati penggunaan nyata.
- **Pengujian Performa**: mengukur waktu respons sistem, kapasitas, dan stabilitas di bawah beban pengguna tertentu.

Hasil pengujian didokumentasikan dan digunakan sebagai dasar untuk perbaikan dan penyempurnaan sistem sebelum penerapan.

### 3.4.6 Pemeliharaan

Tahap pemeliharaan dimulai setelah sistem berhasil diuji dan diterapkan di lingkungan nyata. Pemeliharaan mencakup:

- **Pemeliharaan Korektif**: memperbaiki *bug* atau kesalahan yang teridentifikasi setelah sistem berjalan.
- **Pemeliharaan Adaptif**: menyesuaikan sistem dengan perubahan lingkungan, seperti pembaruan perangkat lunak, perubahan kebutuhan pengguna, atau perubahan infrastruktur.
- **Pemeliharaan Perfektif**: meningkatkan performa dan fungsionalitas sistem berdasarkan umpan balik pengguna dan hasil evaluasi.
- **Pemeliharaan Preventif**: melakukan pembaruan dan pengecekan rutin untuk mencegah terjadinya gangguan sistem.

Dalam kerangka penelitian ini, tahap pemeliharaan bersifat terbatas sesuai dengan cakupan penelitian. Namun, dokumentasi sistem yang lengkap disediakan untuk memfasilitasi proses pemeliharaan oleh pihak instansi di masa mendatang.

---

## 3.5 Perancangan Sistem

Perancangan sistem merupakan tahap penting yang mengubah spesifikasi kebutuhan menjadi blueprint teknis yang siap diimplementasikan. Pada bagian ini, disajikan artefak-artefak desain utama yang menjadi panduan pengembangan sistem antrian berbasis web dengan barcode.

### 3.5.1 Flowchart Sistem

*Flowchart* sistem menggambarkan alur logika kerja sistem secara keseluruhan, mulai dari titik masuk (*entry point*) hingga keluaran (*output*). Berikut adalah deskripsi alur utama dalam *flowchart* sistem antrian ini:

**Alur Registrasi Pasien:**
1. Pasien mengakses halaman registrasi sistem melalui peramban web.
2. Sistem menampilkan formulir pendaftaran antrian.
3. Pasien mengisi data yang diperlukan (nama, nomor identitas, pilihan klaster layanan).
4. Sistem memvalidasi data yang dimasukkan.
5. Jika data valid, sistem membuat nomor antrian secara otomatis berdasarkan urutan kedatangan (FIFO) dan menghasilkan tiket barcode.
6. Sistem menampilkan tiket barcode kepada pasien (dapat dicetak atau disimpan secara digital).
7. Pasien menunggu panggilan dari Petugas Klaster.

**Alur Pelayanan oleh Petugas Klaster:**
1. Petugas Klaster login ke sistem menggunakan akun dengan peran *Petugas*.
2. Sistem menampilkan daftar antrian aktif untuk klaster yang menjadi tanggung jawab petugas.
3. Petugas menekan tombol "Panggil" untuk memanggil nomor antrian berikutnya.
4. Sistem menampilkan nomor antrian yang dipanggil di tampilan publik (*display*).
5. Pasien menunjukkan tiket barcode kepada petugas.
6. Petugas memindai barcode tiket menggunakan pemindai yang terintegrasi dengan sistem.
7. Sistem memverifikasi kesesuaian barcode dengan nomor antrian yang dipanggil.
8. Jika sesuai, sistem mencatat waktu pelayanan dan menandai antrian sebagai "Sedang Dilayani".
9. Setelah selesai, petugas menandai antrian sebagai "Selesai".
10. Sistem memperbarui daftar antrian dan memanggil nomor berikutnya.

**Alur Manajemen oleh Admin:**
1. Admin login ke sistem menggunakan akun dengan peran *Admin*.
2. Admin dapat melakukan konfigurasi klaster, manajemen akun pengguna (Petugas), pemantauan antrian secara *real-time*, dan mengunduh laporan performa layanan.

*Catatan: Gambar flowchart dalam format diagram akan dilampirkan pada lampiran skripsi atau dimasukkan di sini sebagai gambar (Gambar 3.1 — Flowchart Sistem).*

### 3.5.2 Use Case Diagram

*Use Case Diagram* menggambarkan interaksi antara pengguna (*actor*) dengan fungsi-fungsi sistem dari perspektif pengguna. Berikut adalah ringkasan *use case* untuk setiap aktor:

**Aktor: Pasien**
- UC-01: Melakukan Registrasi Antrian
- UC-02: Melihat Nomor Antrian
- UC-03: Menerima Tiket Barcode
- UC-04: Melihat Status Antrian

**Aktor: Petugas Klaster**
- UC-05: Login ke Sistem
- UC-06: Melihat Daftar Antrian Aktif
- UC-07: Memanggil Nomor Antrian
- UC-08: Memindai Barcode Tiket Pasien
- UC-09: Menandai Antrian Selesai
- UC-10: Melihat Riwayat Layanan

**Aktor: Admin**
- UC-11: Login ke Sistem
- UC-12: Mengelola Data Klaster
- UC-13: Mengelola Akun Petugas
- UC-14: Memantau Antrian *Real-Time*
- UC-15: Menghasilkan dan Mengunduh Laporan
- UC-16: Mengkonfigurasi Parameter Sistem

*Catatan: Gambar Use Case Diagram akan dilampirkan (Gambar 3.2 — Use Case Diagram Sistem Antrian).*

### 3.5.3 Activity Diagram

*Activity Diagram* menggambarkan alur aktivitas dan keputusan dalam proses bisnis sistem secara lebih rinci. Diagram ini menggambarkan parallelisme aktivitas dan titik keputusan yang memengaruhi alur proses.

**Activity Diagram Proses Registrasi dan Antrian:**

1. **[Pasien]** → Membuka halaman registrasi → Mengisi formulir → Mengirimkan data
2. **[Sistem]** → Memvalidasi data
   - Jika tidak valid → Menampilkan pesan kesalahan → Kembali ke langkah pengisian formulir
   - Jika valid → Membuat nomor antrian (FIFO) → Menghasilkan barcode → Menampilkan tiket
3. **[Pasien]** → Menerima tiket barcode → Menunggu panggilan
4. **[Petugas Klaster]** → Melihat daftar antrian → Memanggil nomor → Memindai barcode
5. **[Sistem]** → Memverifikasi barcode
   - Jika tidak sesuai → Menampilkan pesan ketidaksesuaian
   - Jika sesuai → Mencatat waktu → Memperbarui status antrian
6. **[Petugas Klaster]** → Memberikan layanan → Menandai selesai
7. **[Sistem]** → Memperbarui log → Memanggil antrian berikutnya

*Catatan: Gambar Activity Diagram akan dilampirkan (Gambar 3.3 — Activity Diagram Proses Antrian).*

### 3.5.4 Entity Relationship Diagram (ERD)

*Entity Relationship Diagram* (ERD) menggambarkan struktur data sistem dan hubungan antara entitas-entitas yang dikelola.

**Entitas Utama dan Atributnya:**

| Entitas         | Atribut Utama                                                                            |
|-----------------|------------------------------------------------------------------------------------------|
| **Pasien**      | id_pasien, nama_pasien, no_identitas, no_telepon, created_at                            |
| **Antrian**     | id_antrian, no_antrian, id_pasien, id_klaster, barcode, status, waktu_daftar, waktu_panggil, waktu_selesai |
| **Klaster**     | id_klaster, nama_klaster, deskripsi, status_aktif                                       |
| **Petugas**     | id_petugas, nama_petugas, username, password (hashed), id_klaster                      |
| **Admin**       | id_admin, nama_admin, username, password (hashed)                                       |
| **Log Aktivitas** | id_log, id_petugas, id_antrian, aksi, timestamp                                       |

**Relasi Antar Entitas:**
- Satu **Pasien** dapat memiliki banyak **Antrian** (one-to-many).
- Satu **Klaster** dapat memiliki banyak **Antrian** (one-to-many).
- Satu **Klaster** dapat dikelola oleh satu atau beberapa **Petugas** (one-to-many).
- Setiap **Antrian** hanya dimiliki oleh satu **Pasien** dan satu **Klaster** (many-to-one).
- Setiap aksi **Petugas** pada **Antrian** dicatat dalam **Log Aktivitas**.

*Catatan: Gambar ERD akan dilampirkan (Gambar 3.4 — ERD Sistem Antrian).*

### 3.5.5 Perancangan Database

Perancangan basis data mengacu pada ERD yang telah dibuat. Berikut adalah deskripsi skema tabel-tabel utama dalam basis data sistem antrian:

**Tabel `pasien`**
```sql
CREATE TABLE pasien (
    id_pasien     INT PRIMARY KEY AUTO_INCREMENT,
    nama_pasien   VARCHAR(100) NOT NULL,
    no_identitas  VARCHAR(50)  UNIQUE,
    no_telepon    VARCHAR(20),
    created_at    DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

**Tabel `klaster`**
```sql
CREATE TABLE klaster (
    id_klaster    INT PRIMARY KEY AUTO_INCREMENT,
    nama_klaster  VARCHAR(100) NOT NULL,
    deskripsi     TEXT,
    status_aktif  TINYINT(1) DEFAULT 1
);
```

**Tabel `antrian`**
```sql
CREATE TABLE antrian (
    id_antrian      INT PRIMARY KEY AUTO_INCREMENT,
    no_antrian      VARCHAR(20) NOT NULL,
    id_pasien       INT,
    id_klaster      INT,
    barcode         VARCHAR(255) UNIQUE,
    status          ENUM('menunggu','dipanggil','dilayani','selesai','batal') DEFAULT 'menunggu',
    waktu_daftar    DATETIME DEFAULT CURRENT_TIMESTAMP,
    waktu_panggil   DATETIME,
    waktu_selesai   DATETIME,
    FOREIGN KEY (id_pasien)  REFERENCES pasien(id_pasien),
    FOREIGN KEY (id_klaster) REFERENCES klaster(id_klaster)
);
```

**Tabel `petugas`**
```sql
CREATE TABLE petugas (
    id_petugas    INT PRIMARY KEY AUTO_INCREMENT,
    nama_petugas  VARCHAR(100) NOT NULL,
    username      VARCHAR(50)  UNIQUE NOT NULL,
    password      VARCHAR(255) NOT NULL,
    id_klaster    INT,
    FOREIGN KEY (id_klaster) REFERENCES klaster(id_klaster)
);
```

**Tabel `admin`**
```sql
CREATE TABLE admin (
    id_admin    INT PRIMARY KEY AUTO_INCREMENT,
    nama_admin  VARCHAR(100) NOT NULL,
    username    VARCHAR(50)  UNIQUE NOT NULL,
    password    VARCHAR(255) NOT NULL
);
```

**Tabel `log_aktivitas`**
```sql
CREATE TABLE log_aktivitas (
    id_log       INT PRIMARY KEY AUTO_INCREMENT,
    id_petugas   INT,
    id_antrian   INT,
    aksi         VARCHAR(100),
    timestamp    DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_petugas) REFERENCES petugas(id_petugas),
    FOREIGN KEY (id_antrian) REFERENCES antrian(id_antrian)
);
```

Skema basis data di atas dirancang untuk mendukung seluruh fungsionalitas sistem antrian, termasuk pencatatan waktu yang akurat untuk analisis performa layanan (waktu tunggu = `waktu_panggil - waktu_daftar`; durasi layanan = `waktu_selesai - waktu_panggil`).

### 3.5.6 Perancangan Antarmuka Sistem

Perancangan antarmuka (*User Interface/UI*) bertujuan untuk menciptakan tampilan yang intuitif, responsif, dan sesuai dengan peran pengguna masing-masing. Pendekatan desain yang digunakan mengutamakan kemudahan penggunaan (*usability*) dan aksesibilitas di berbagai ukuran layar.

**Halaman-halaman utama yang dirancang:**

1. **Halaman Registrasi Antrian (Pasien)**:
   - Formulir pendaftaran (nama, nomor identitas, pilihan klaster).
   - Tombol "Daftar Antrian".
   - Tampilan tiket barcode setelah pendaftaran berhasil (dengan opsi cetak/simpan).

2. **Halaman Dashboard Petugas Klaster**:
   - Daftar antrian aktif (menunggu, dipanggil, dilayani).
   - Tombol "Panggil Selanjutnya".
   - Antarmuka pemindaian barcode.
   - Informasi pasien yang sedang dilayani.

3. **Halaman Dashboard Admin**:
   - Ringkasan statistik antrian (*real-time*): jumlah pasien terdaftar, dilayani, menunggu.
   - Manajemen klaster dan petugas.
   - Laporan performa layanan (grafik dan tabel).
   - Pengaturan sistem.

4. **Halaman Display Antrian (Publik)**:
   - Tampilan nomor antrian yang sedang dipanggil di setiap klaster.
   - Dapat ditampilkan di layar monitor publik di ruang tunggu.

5. **Halaman Login (Petugas & Admin)**:
   - Formulir login dengan validasi.
   - Pengalihan otomatis ke dashboard sesuai peran setelah login berhasil.

*Catatan: Wireframe/mockup antarmuka akan dilampirkan (Gambar 3.5 dst. — Perancangan Antarmuka Sistem).*

---

## 3.6 Alur Sistem Antrian

Bagian ini mendeskripsikan alur kerja lengkap sistem antrian berbasis web dengan barcode, yang memetakan setiap tindakan pengguna dari setiap peran (Admin, Petugas Klaster, Pasien) beserta respons sistem dan pencatatan waktu (*timestamp*) yang relevan.

### Langkah 1: Pasien Melakukan Registrasi

| # | Aktor   | Tindakan                                          | Respons Sistem                                                               | Timestamp    |
|---|---------|---------------------------------------------------|------------------------------------------------------------------------------|--------------|
| 1 | Pasien  | Mengakses halaman registrasi sistem via browser   | Sistem menampilkan formulir pendaftaran antrian                              | T1 (akses)   |
| 2 | Pasien  | Mengisi formulir (nama, no. identitas, klaster)   | Sistem melakukan validasi input secara *real-time*                           | T2 (input)   |
| 3 | Pasien  | Mengklik tombol "Daftar"                          | Sistem menyimpan data, membuat nomor antrian FIFO, dan menghasilkan barcode  | T3 (daftar)  |
| 4 | Sistem  | —                                                 | Menampilkan tiket antrian digital berisi nomor antrian dan barcode           | T3 (tiket)   |
| 5 | Pasien  | Menyimpan/mencetak tiket barcode                  | —                                                                            | T3 (tiket)   |

**Catatan**: Waktu registrasi (T3) dicatat sebagai `waktu_daftar` dalam tabel antrian dan menjadi dasar penentuan urutan FIFO. Semakin awal T3, semakin awal pasien dipanggil di klaster yang dipilih.

### Langkah 2: Pasien Menunggu Panggilan

| # | Aktor   | Tindakan                                                        | Respons Sistem                                                              |
|---|---------|-----------------------------------------------------------------|-----------------------------------------------------------------------------|
| 6 | Pasien  | Menunggu di ruang tunggu sambil memantau display antrian        | Sistem memperbarui tampilan *display* publik secara *real-time*             |
| 7 | Pasien  | Melihat nomor antrian yang dipanggil di layar display           | Sistem menampilkan nomor antrian aktif dan klaster tujuan                   |

### Langkah 3: Petugas Klaster Memanggil dan Melayani Pasien

| # | Aktor             | Tindakan                                              | Respons Sistem                                                              | Timestamp      |
|---|-------------------|-------------------------------------------------------|-----------------------------------------------------------------------------|----------------|
| 8 | Petugas Klaster   | Login ke sistem dengan akun Petugas                   | Sistem memverifikasi kredensial dan menampilkan dashboard klaster           | T4 (login)     |
| 9 | Petugas Klaster   | Melihat daftar antrian aktif                          | Sistem menampilkan daftar pasien menunggu berdasarkan urutan FIFO           | —              |
|10 | Petugas Klaster   | Mengklik "Panggil Selanjutnya"                        | Sistem memperbarui status antrian menjadi "Dipanggil", memperbarui *display*| T5 (panggil)   |
|11 | Pasien            | Mendatangi meja Petugas Klaster setelah namanya dipanggil | —                                                                       | —              |
|12 | Petugas Klaster   | Memindai barcode tiket pasien menggunakan *scanner*   | Sistem membaca barcode, memvalidasi kesesuaian dengan nomor yang dipanggil  | T6 (scan)      |
|13 | Sistem            | —                                                     | Jika valid: mengubah status menjadi "Sedang Dilayani", mencatat T6         | T6 (mulai)     |
|14 | Petugas Klaster   | Memberikan layanan kepada pasien                      | —                                                                           | —              |
|15 | Petugas Klaster   | Mengklik "Selesai" setelah layanan selesai            | Sistem mengubah status menjadi "Selesai", mencatat waktu selesai           | T7 (selesai)   |

**Metrik yang tercatat secara otomatis:**
- **Waktu tunggu pasien** = T5 (panggil) − T3 (daftar)
- **Durasi verifikasi** = T6 (scan) − T5 (panggil)
- **Durasi layanan** = T7 (selesai) − T6 (scan)
- **Total waktu dari daftar hingga selesai** = T7 (selesai) − T3 (daftar)

### Langkah 4: Admin Memantau dan Mengevaluasi

| # | Aktor   | Tindakan                                           | Respons Sistem                                                            |
|---|---------|----------------------------------------------------|---------------------------------------------------------------------------|
|16 | Admin   | Login ke sistem dengan akun Admin                  | Sistem menampilkan dashboard Admin dengan statistik *real-time*           |
|17 | Admin   | Memantau antrian aktif di semua klaster            | Sistem menampilkan status antrian semua klaster secara *real-time*        |
|18 | Admin   | Mengunduh laporan performa harian/bulanan           | Sistem menghasilkan laporan berisi rata-rata waktu tunggu, throughput, dll.|
|19 | Admin   | Mengkonfigurasi klaster atau akun petugas          | Sistem menyimpan perubahan konfigurasi                                    |

### Evaluasi dan Metode Statistik

Untuk mengukur efektivitas sistem yang dikembangkan, evaluasi dilakukan dengan membandingkan kondisi sebelum dan sesudah implementasi sistem. Instrumen evaluasi yang digunakan meliputi:

- **Kuesioner Kepuasan Pengguna**: dikembangkan berdasarkan skala Likert 5 poin, mencakup dimensi kemudahan penggunaan, kecepatan layanan, kejelasan antrian, dan kepuasan keseluruhan. Instrumen diuji menggunakan:
  - **Uji Validitas**: pearson correlation (r hitung > r tabel dengan α = 0.05).
  - **Uji Reliabilitas**: Cronbach's Alpha (nilai ≥ 0.70 dianggap reliabel).

- **Pengukuran Waktu Tunggu**: data waktu tunggu sebelum dan sesudah implementasi sistem dikumpulkan dan dibandingkan. Uji statistik yang digunakan:
  - **Paired t-test**: jika data berdistribusi normal (diuji dengan Shapiro-Wilk atau Kolmogorov-Smirnov).
  - **Wilcoxon Signed-Rank Test**: sebagai alternatif non-parametrik jika asumsi normalitas tidak terpenuhi.

- **Jumlah Sampel**: **[harap isi jumlah responden/sampel sesuai dengan perhitungan atau pertimbangan peneliti, misalnya: 30 pasien untuk uji statistik parametrik minimal]**.

- **Etika Penelitian**: semua partisipan mendapat penjelasan dan memberikan persetujuan (*informed consent*) sebelum dilibatkan. Data pribadi responden dijaga kerahasiaannya dan hanya digunakan untuk keperluan penelitian.

---

## Apa yang Perlu Dilengkapi

Berikut adalah daftar singkat bidang/informasi yang perlu dilengkapi oleh peneliti sebelum dokumen ini dianggap final:

1. **Nama instansi/klinik/rumah sakit**: ganti semua tanda `[nama instansi — harap dilengkapi]` dengan nama nyata.
2. **Alamat instansi**: ganti `[alamat lengkap instansi — harap dilengkapi]` dengan alamat lengkap.
3. **Alasan pemilihan lokasi penelitian**: isi penjelasan mengapa instansi tersebut dipilih.
4. **Periode penelitian**: ganti `[bulan awal] — [bulan akhir] [tahun]` dengan periode riil.
5. **Jumlah informan/responden**: isi jumlah informan untuk wawancara dan jumlah sampel untuk pengujian.
6. **Teknologi yang dipilih**: isi framework back-end, front-end, dan DBMS yang digunakan.
7. **Gambar diagram**: tambahkan gambar Flowchart, Use Case, Activity Diagram, ERD, dan wireframe antarmuka yang telah dibuat.
8. **Penelitian terdahulu (Subbab 2.7)**: tambahkan 3–5 penelitian terdahulu tambahan dengan tabel perbandingan.
9. **Referensi lengkap**: lengkapi judul, nama jurnal, volume, dan halaman untuk Aidha Wardhani & Mustika Dewi (2024) dan Attabarok et al. (2025).
10. **Tabel jadwal penelitian**: sesuaikan tabel jadwal di Subbab 3.2 dengan jadwal nyata penelitian.

---

*Daftar Pustaka (inline references used in this chapter):*
- Aidha Wardhani, & Mustika Dewi. (2024). *[Judul lengkap artikel — harap dilengkapi]*. *[Nama Jurnal]*, *[Volume]* (*[Nomor]*), *[Halaman]*.
- Attabarok, [nama depan], et al. (2025). *[Judul lengkap artikel — harap dilengkapi]*. *[Nama Jurnal/Prosiding]*, *[Volume]* (*[Nomor]*), *[Halaman]*.
