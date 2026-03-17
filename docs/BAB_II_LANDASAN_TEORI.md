# BAB II
# LANDASAN TEORI

## 2.1 Sistem Antrian

Sistem antrian merupakan suatu susunan yang mengatur urutan entitas (orang, data, atau objek) yang menunggu untuk mendapatkan suatu layanan. Menurut teori antrian, entitas yang datang disebut *arrival*, tempat layanan disebut *server*, dan entitas yang sedang menunggu disebut *queue*. Model antrian yang paling umum digunakan dalam pelayanan publik adalah model First-In First-Out (FIFO), di mana entitas yang pertama kali masuk ke sistem juga akan pertama kali dilayani (Gross et al., 2008).

Penerapan sistem antrian berbasis teknologi informasi memungkinkan manajemen antrian yang lebih terstruktur, transparan, dan efisien. Data waktu kedatangan, waktu tunggu, dan waktu pelayanan dapat dicatat secara otomatis sehingga memudahkan evaluasi kinerja layanan secara berkala.

## 2.2 Barcode dan Penggunaannya dalam Sistem Informasi

Barcode adalah representasi data dalam bentuk visual yang dapat dibaca oleh mesin (mesin pembaca/scanner). Barcode satu dimensi (1D) seperti Code 128 dan barcode dua dimensi (2D) seperti QR Code banyak dimanfaatkan dalam sistem identifikasi dan pelacakan objek karena kemudahan implementasinya dan biaya yang relatif rendah. Dalam konteks sistem antrian, barcode digunakan sebagai identitas unik tiket sehingga petugas dapat memverifikasi kedatangan pasien secara cepat dan akurat tanpa input manual.

## 2.3 Sistem Informasi Berbasis Web

Sistem informasi berbasis web adalah aplikasi yang berjalan di atas infrastruktur internet atau intranet dan dapat diakses melalui peramban (*browser*) tanpa memerlukan instalasi khusus di sisi klien. Keunggulan utama pendekatan ini adalah aksesibilitas lintas platform, kemudahan pembaruan, dan pengelolaan terpusat. Pengembangan sistem berbasis web umumnya mengikuti arsitektur *client-server* di mana logika bisnis dan data dikelola di sisi server, sementara antarmuka dirender di sisi klien.

## 2.4 Konsep Role-Based Access Control (RBAC)

Role-Based Access Control (RBAC) adalah mekanisme kontrol akses yang mengatur hak akses pengguna berdasarkan peran (*role*) yang dimilikinya dalam sistem. Setiap peran memiliki sekumpulan izin (*permission*) tertentu, dan pengguna mendapatkan izin melalui keanggotaan dalam suatu peran. RBAC menyederhanakan administrasi sistem karena perubahan hak akses cukup dilakukan pada level peran, tidak perlu mengubah konfigurasi setiap pengguna secara individual (Ferraiolo et al., 2001).

Dalam konteks sistem antrian berbasis barcode ini, tiga peran utama didefinisikan sebagai berikut.

| Peran | Deskripsi Singkat |
|---|---|
| **Admin** | Mengelola konfigurasi sistem, akun pengguna, dan laporan analitik |
| **Petugas Klaster** | Mengoperasikan loket, memindai barcode, memanggil nomor, dan mencatat hasil pelayanan |
| **Pasien** | Melakukan registrasi, memperoleh tiket/barcode, memantau posisi antrian |

## 2.5 Tinjauan Teknologi yang Digunakan

### 2.5.1 PHP dan Framework Laravel

Laravel adalah framework PHP yang mengikuti pola arsitektur Model-View-Controller (MVC) dan menyediakan fitur bawaan seperti autentikasi, routing, ORM (Eloquent), migrasi basis data, dan antrian pekerjaan. Kemudahan pengembangan dan komunitas yang besar menjadikan Laravel salah satu pilihan utama dalam pengembangan sistem informasi web skala menengah.

### 2.5.2 Basis Data Relasional

Basis data relasional seperti MySQL atau MariaDB digunakan untuk menyimpan data terstruktur dengan integritas referensial melalui *foreign key*. Tabel inti pada sistem ini mencakup `users`, `patients`, `tickets`, `queue_records`, dan `services`. Normalisasi data sampai minimal bentuk normal ketiga (3NF) diterapkan untuk menghindari redundansi.

### 2.5.3 Antarmuka Pengguna (Front-End)

Antarmuka dikembangkan menggunakan HTML, CSS (Tailwind CSS), dan JavaScript yang memberikan tampilan responsif dan ramah pengguna di berbagai perangkat. Prinsip desain yang diterapkan meliputi kontras warna yang tinggi untuk keterbacaan nomor antrian di layar publik, navigasi yang intuitif, dan *feedback* visual yang jelas untuk setiap aksi pengguna.

## 2.6 Metodologi Pengembangan: Research and Development (R&D) Terintegrasi dengan Prototyping

### 2.6.1 Research and Development (R&D)

Research and Development (R&D) adalah pendekatan penelitian yang bertujuan menghasilkan produk tertentu sekaligus menguji efektivitas produk tersebut (Sugiyono, 2019). Model R&D menekankan siklus yang sistematis: peneliti mengidentifikasi permasalahan nyata di lapangan, merancang solusi berdasarkan kajian teori dan praktik, mengembangkan produk, kemudian menguji dan merevisi produk berulang kali hingga memenuhi kriteria kelayakan yang ditetapkan. Pendekatan ini lazim digunakan dalam penelitian di bidang teknologi pendidikan, sistem informasi, dan rekayasa perangkat lunak karena menghasilkan artefak konkret yang dapat langsung diterapkan di lapangan.

### 2.6.2 Prototyping sebagai Strategi Iteratif

Prototyping adalah teknik pengembangan perangkat lunak yang menekankan pembuatan versi awal sistem (*prototype*) secara cepat untuk kemudian dievaluasi oleh pengguna dan dikembangkan lebih lanjut berdasarkan masukan yang diperoleh (Pressman & Maxim, 2020). Model ini sangat efektif ketika kebutuhan pengguna belum sepenuhnya terdefinisi di awal atau ketika pengguna membutuhkan representasi konkret sebelum dapat memberikan umpan balik yang bermakna. Setiap iterasi menghasilkan prototipe yang lebih matang hingga akhirnya menghasilkan produk akhir yang memenuhi kebutuhan pengguna.

Siklus satu iterasi prototyping meliputi empat tahap utama:

1. **Pengumpulan kebutuhan** — mengidentifikasi kebutuhan tambahan atau perubahan berdasarkan evaluasi prototipe sebelumnya;
2. **Pengembangan cepat** (*rapid build*) — mengimplementasikan fitur-fitur yang disepakati pada iterasi berjalan;
3. **Demonstrasi dan evaluasi** — mendemonstrasikan prototipe kepada pemangku kepentingan (Admin, Petugas Klaster, Pasien) untuk memperoleh umpan balik;
4. **Perbaikan dan penyempurnaan** — merevisi prototipe berdasarkan umpan balik sebelum melanjutkan ke iterasi berikutnya.

### 2.6.3 Pemilihan Metodologi: R&D Terintegrasi Prototyping

Penelitian ini memilih pendekatan **Research and Development (R&D) yang diintegrasikan dengan strategi Prototyping** sebagai metodologi pengembangan sistem antrian berbasis barcode dan FIFO. Alasan pemilihan metodologi ini adalah sebagai berikut.

1. **Kesesuaian dengan tujuan penelitian.** Tujuan penelitian ini adalah menghasilkan sistem informasi antrian yang dapat langsung diterapkan di [nama instansi]. R&D secara inheren berorientasi pada produk (*product-oriented*) dan mewajibkan pengujian empiris, yang selaras dengan kebutuhan penelitian ini.

2. **Kebutuhan yang berkembang secara bertahap.** Kebutuhan pemangku kepentingan (Admin, Petugas Klaster, Pasien) tidak selalu dapat didefinisikan secara lengkap sejak awal. Prototyping memungkinkan negosiasi kebutuhan yang berkelanjutan melalui demonstrasi prototipe nyata pada setiap iterasi sehingga risiko kesalahpahaman kebutuhan dapat diminimalkan.

3. **Efisiensi waktu pengembangan.** Dengan membagi pengembangan menjadi **3 iterasi × 2 minggu**, tim dapat memprioritaskan fitur-fitur inti pada iterasi awal dan secara bertahap menambahkan fitur pelengkap. Pendekatan ini mengurangi risiko kegagalan proyek akibat perubahan kebutuhan di tahap akhir.

4. **Kualitas produk yang terverifikasi.** Setiap iterasi diakhiri dengan pengujian fungsional dan *User Acceptance Testing* (UAT) berbasis kriteria penerimaan (*acceptance criteria*) yang terukur, sehingga kualitas sistem dapat dipantau secara inkremental dan terdokumentasi dengan baik.

5. **Relevansi akademis dan praktis.** Kombinasi R&D dan Prototyping telah banyak diterapkan dan dikaji dalam literatur sistem informasi kesehatan dan pelayanan publik, sehingga memberikan fondasi teori yang kuat sekaligus menghasilkan kontribusi praktis yang nyata bagi instansi mitra.

Dengan demikian, metodologi R&D terintegrasi Prototyping dipilih sebagai kerangka kerja yang paling tepat untuk mencapai tujuan penelitian ini, mengakomodasi dinamika kebutuhan pengguna, dan menghasilkan sistem yang telah teruji sebelum diserahkan kepada instansi.

## 2.7 Penelitian Terdahulu

Beberapa penelitian terdahulu yang relevan dijadikan acuan dalam penelitian ini, antara lain:

- [Nama Penulis, Tahun] meneliti tentang sistem antrian elektronik berbasis web di [nama instansi/bidang] dan menemukan bahwa penggunaan teknologi digital mampu mengurangi waktu tunggu rata-rata sebesar [X]%.
- [Nama Penulis, Tahun] mengembangkan sistem manajemen antrian menggunakan barcode di lingkungan [bidang] dengan metode [metode] dan menghasilkan [temuan utama].
- [Nama Penulis, Tahun] menerapkan model prototyping dalam pengembangan sistem informasi [bidang] dan melaporkan bahwa pendekatan iteratif secara signifikan meningkatkan kepuasan pengguna akhir.

Perbedaan penelitian ini dengan penelitian-penelitian tersebut terletak pada integrasi antara sistem FIFO berbasis barcode, pendekatan R&D terintegrasi Prototyping, dan konteks spesifik pelayanan di [nama instansi] dengan peran yang terdefinisi (Admin, Petugas Klaster, Pasien).

---

*Referensi ditulis menggunakan gaya [APA/IEEE/Chicago] sesuai ketentuan [nama institusi].*
