# BAB II
# LANDASAN TEORI

---

## 2.1 Sistem Informasi

Sistem informasi merupakan salah satu fondasi utama dalam pengembangan berbagai aplikasi berbasis teknologi, termasuk sistem antrian berbasis web yang menjadi fokus penelitian ini. Dengan memahami konsep dasar sistem, informasi, dan sistem informasi secara menyeluruh, perancangan dan implementasi sistem dapat dilakukan secara lebih terarah dan terstruktur.

### 2.1.1 Pengertian Sistem

Sistem dapat diartikan sebagai sekumpulan elemen atau komponen yang saling berhubungan dan berinteraksi satu sama lain untuk mencapai tujuan tertentu. Setiap sistem terdiri atas beberapa unsur pokok, yaitu **input** (masukan), **proses** (pengolahan), **output** (keluaran), serta mekanisme **umpan balik** (*feedback*) yang berfungsi mengendalikan kinerja sistem agar tetap berjalan sesuai tujuan yang ditetapkan. Selain itu, suatu sistem juga memiliki **batas sistem** (*boundary*) yang memisahkan sistem dari lingkungan di sekitarnya, serta **antarmuka** (*interface*) yang menghubungkan sistem dengan elemen luar.

Komponen-komponen yang umumnya membentuk suatu sistem antara lain:
1. **Komponen** (*component*): bagian-bagian pembentuk sistem yang saling bekerja sama.
2. **Batasan** (*boundary*): ruang lingkup yang membedakan sistem dengan lingkungan luarnya.
3. **Lingkungan luar** (*environment*): segala sesuatu di luar sistem yang dapat memengaruhi kinerja sistem.
4. **Penghubung** (*interface*): media yang menghubungkan satu subsistem dengan subsistem lainnya.
5. **Masukan** (*input*): segala sesuatu yang masuk ke dalam sistem untuk diproses.
6. **Keluaran** (*output*): hasil akhir dari proses pengolahan sistem.
7. **Pengolah** (*process*): mekanisme yang mengubah input menjadi output.
8. **Tujuan** (*goal*): sasaran akhir yang ingin dicapai oleh sistem.

Dalam konteks penelitian ini, sistem antrian berbasis web dirancang dengan memperhatikan seluruh komponen tersebut: input berupa data pendaftaran pasien, proses berupa pengelolaan antrian secara otomatis dengan disiplin FIFO dan pemindaian barcode, serta output berupa informasi nomor antrian dan status layanan yang dapat dipantau secara *real-time*.

### 2.1.2 Pengertian Informasi

Informasi adalah data yang telah diolah, disusun, atau diberi konteks sehingga memiliki makna dan nilai guna bagi penerimanya, khususnya dalam mendukung pemahaman atau proses pengambilan keputusan. Informasi yang baik harus memenuhi sejumlah kriteria kualitas agar dapat dimanfaatkan secara optimal, di antaranya:

- **Akurat** (*accurate*): informasi bebas dari kesalahan dan tidak menyesatkan.
- **Relevan** (*relevant*): informasi sesuai dengan kebutuhan pengguna dan konteks penggunaannya.
- **Tepat waktu** (*timely*): informasi tersedia pada saat dibutuhkan.
- **Lengkap** (*complete*): informasi mencakup semua hal yang diperlukan oleh penerima.
- **Konsisten** (*consistent*): informasi tidak bertentangan antara satu bagian dengan bagian lainnya.

Dalam sistem antrian berbasis web yang dikembangkan, informasi yang dihasilkan meliputi nomor antrian pasien, status antrian saat ini, perkiraan waktu tunggu, serta rekap data pelayanan harian. Informasi ini harus akurat dan tepat waktu agar pasien dan Petugas Klaster dapat membuat keputusan yang tepat.

### 2.1.3 Pengertian Sistem Informasi

Sistem informasi adalah suatu sistem yang mengintegrasikan **manusia**, **prosedur**, **data**, **perangkat keras** (*hardware*), **perangkat lunak** (*software*), dan **jaringan komunikasi** untuk menjalankan aktivitas pengumpulan, pengolahan, penyimpanan, dan penyajian informasi guna mendukung operasional dan pengambilan keputusan organisasi (Attabarok et al., 2025).

Komponen-komponen utama sistem informasi meliputi:
- **People** (pengguna): individu yang berinteraksi dengan sistem, seperti Admin, Petugas Klaster, dan Pasien dalam penelitian ini.
- **Procedure** (prosedur): serangkaian aturan dan alur kerja yang mengatur cara data dikumpulkan, diolah, dan disajikan.
- **Data**: kumpulan fakta mentah yang menjadi bahan baku pemrosesan informasi.
- **Hardware**: perangkat fisik seperti komputer, printer barcode, dan *scanner*.
- **Software**: perangkat lunak aplikasi dan sistem operasi yang menjalankan fungsi sistem.
- **Network** (jaringan): infrastruktur komunikasi yang menghubungkan seluruh komponen sistem.

Aktivitas utama dalam sistem informasi mencakup: (1) *input* — memasukkan data ke dalam sistem; (2) *processing* — mengolah data menjadi informasi bermakna; (3) *storage* — menyimpan data dan informasi; (4) *output* — menyajikan informasi kepada pengguna; dan (5) *control* — memastikan sistem berjalan sesuai tujuan.

Dalam penelitian ini, sistem informasi berbasis web dirancang untuk mengotomasi proses pendaftaran dan pengelolaan antrian pasien. Sistem ini melibatkan tiga peran utama — Admin, Petugas Klaster, dan Pasien — yang masing-masing memiliki hak akses dan tanggung jawab berbeda sesuai prosedur yang telah ditetapkan (Aidha Wardhani & Mustika Dewi, 2024).

---

## 2.2 Sistem Antrian

Sistem antrian hadir sebagai solusi terhadap permasalahan pengelolaan antrean yang tidak teratur, khususnya di lingkungan layanan publik seperti fasilitas kesehatan. Dengan penerapan sistem antrian yang tepat, proses pelayanan dapat berjalan lebih efisien, transparan, dan dapat diukur kinerjanya.

### 2.2.1 Pengertian Sistem Antrian

Sistem antrian (*queueing system*) adalah suatu mekanisme atau model terstruktur yang mengatur proses kedatangan entitas (pelanggan, pasien, atau berkas) yang membutuhkan layanan, baris tunggu yang terbentuk sebelum layanan diberikan, serta proses pemberian layanan itu sendiri. Sistem antrian bertujuan agar setiap entitas mendapatkan layanan secara adil dan teratur, sekaligus meminimalkan waktu tunggu (Attabarok et al., 2025).

Secara teoritis, model sistem antrian direpresentasikan dengan notasi Kendall: **A/B/c/K/N**, di mana:
- **A**: distribusi waktu antar-kedatangan
- **B**: distribusi waktu layanan
- **c**: jumlah server/loket
- **K**: kapasitas sistem (batas maksimum antrian)
- **N**: ukuran populasi sumber kedatangan

Dalam praktik layanan kesehatan, sistem antrian umumnya berpola kedatangan acak (distribusi Poisson) dengan satu atau lebih loket pelayanan. Penerapan sistem antrian berbasis web dengan barcode pada penelitian ini dirancang untuk mengakomodasi model tersebut secara digital dan otomatis.

### 2.2.2 Tujuan Sistem Antrian

Penerapan sistem antrian dalam sebuah organisasi layanan memiliki beberapa tujuan utama, yaitu:

1. **Mengurangi waktu tunggu** pasien/pelanggan dengan mendistribusikan beban layanan secara merata.
2. **Meningkatkan utilisasi server** (loket/petugas) agar tidak terjadi pembebanan berlebih (*overload*) maupun waktu menganggur yang panjang.
3. **Menjaga keteraturan dan keadilan** proses pelayanan, sehingga setiap entitas mendapat giliran sesuai urutan atau prioritas yang telah ditentukan.
4. **Menyediakan data kinerja layanan** — seperti rata-rata waktu tunggu, throughput, dan tingkat pelayanan — untuk keperluan evaluasi dan perbaikan berkelanjutan.
5. **Meningkatkan kepuasan pengguna** melalui proses layanan yang lebih transparan dan dapat diprediksi.

Dalam penelitian ini, sistem antrian berbasis web dengan barcode bertujuan memenuhi semua tujuan di atas secara terpadu, dengan menampilkan status antrian secara *real-time* kepada Pasien dan memudahkan Petugas Klaster dalam memanggil nomor antrian berikutnya.

### 2.2.3 Komponen Sistem Antrian

Sebuah sistem antrian terdiri atas beberapa komponen yang saling berkaitan, yaitu:

| Komponen | Keterangan |
|---|---|
| **Sumber kedatangan** | Populasi dari mana entitas (pasien) berasal; bisa terbatas atau tidak terbatas. |
| **Proses kedatangan** | Pola atau jadwal kedatangan entitas, misalnya acak (stokastik) atau terjadwal. |
| **Baris tunggu** (*queue*) | Tempat entitas menunggu giliran layanan; memiliki kapasitas tertentu. |
| **Disiplin antrian** | Aturan urutan layanan: FIFO, LIFO, *priority*, atau acak. |
| **Fasilitas pelayanan** | Jumlah dan kapasitas server (loket, Petugas Klaster, dokter). |
| **Waktu layanan** | Lama waktu yang dibutuhkan untuk melayani satu entitas. |
| **Keluaran** (*departure*) | Entitas yang telah selesai dilayani dan meninggalkan sistem. |

Pada sistem yang dikembangkan dalam penelitian ini, setiap komponen direpresentasikan secara digital: sumber kedatangan adalah Pasien yang mendaftar melalui antarmuka web, baris tunggu dikelola dalam basis data, disiplin antrian menggunakan metode FIFO, dan fasilitas pelayanan adalah Petugas Klaster di masing-masing klaster layanan (Aidha Wardhani & Mustika Dewi, 2024).

---

## 2.3 Metode Antrian

Metode antrian menentukan urutan atau cara entitas dilayani oleh sistem. Pilihan metode yang tepat sangat berpengaruh terhadap efisiensi dan keadilan proses layanan.

### 2.3.1 Metode First In First Out (FIFO)

**First In First Out (FIFO)** adalah disiplin antrian yang paling umum digunakan, di mana entitas yang pertama kali tiba akan menjadi entitas pertama yang dilayani. Prinsip ini identik dengan konsep "siapa cepat dia dapat" dan menjamin keadilan prosedural dalam antrian.

**Keunggulan FIFO:**
- Sederhana dan mudah dipahami oleh pengguna maupun petugas.
- Adil karena tidak ada entitas yang "dipotong" tanpa alasan khusus.
- Mudah diimplementasikan secara teknis baik secara manual maupun digital.
- Meminimalkan potensi konflik di antara pengguna layanan.

**Kelemahan FIFO:**
- Tidak mempertimbangkan kondisi atau prioritas mendesak (misalnya pasien gawat darurat).
- Performa dapat menurun apabila terdapat variasi waktu layanan yang sangat besar antar-entitas.

**Implementasi FIFO dalam penelitian ini:** Setiap Pasien yang mendaftar melalui sistem akan mendapatkan nomor antrian berdasarkan urutan waktu kedatangan/pendaftaran (timestamp). Petugas Klaster memanggil nomor antrian secara berurutan dari angka terkecil ke terbesar. Sistem otomatis mencatat waktu pendaftaran dan waktu pemanggilan sehingga seluruh riwayat layanan terdokumentasi dengan baik (Attabarok et al., 2025).

---

## 2.4 Barcode

Barcode merupakan teknologi identifikasi otomatis yang memungkinkan sistem membaca dan memverifikasi data secara cepat tanpa input manual. Penggunaan barcode dalam sistem antrian berbasis web memberikan nilai tambah berupa kecepatan verifikasi dan akurasi data.

### 2.4.1 Pengertian Barcode

**Barcode** adalah representasi data dalam bentuk pola garis paralel (satu dimensi) atau simbol geometris (dua dimensi) yang dapat dibaca secara optis menggunakan *scanner* atau kamera. Data yang tersimpan dalam barcode kemudian diterjemahkan menjadi informasi digital yang dapat langsung diproses oleh sistem komputer. Secara teknis, barcode berfungsi sebagai jembatan antara objek fisik (tiket, kartu, label) dan sistem informasi digital yang mengelolanya (Attabarok et al., 2025).

### 2.4.2 Jenis-Jenis Barcode

Barcode secara umum dibagi menjadi dua kategori utama:

**1. Barcode Satu Dimensi (1D / Linear)**
- **UPC** (*Universal Product Code*): umum digunakan pada produk ritel.
- **EAN** (*European Article Number*): standar internasional untuk identifikasi produk.
- **Code 39**: mendukung karakter alfanumerik, cocok untuk keperluan industri.
- **Code 128**: berkapasitas lebih tinggi dibanding Code 39, mendukung seluruh karakter ASCII.

**2. Barcode Dua Dimensi (2D)**
- **QR Code** (*Quick Response Code*): populer karena mampu menyimpan data lebih banyak dan dapat dibaca dari berbagai sudut menggunakan kamera smartphone.
- **Data Matrix**: digunakan pada komponen elektronik dan produk farmasi.
- **PDF417**: sering digunakan pada dokumen perjalanan dan kartu identitas.

Barcode 2D, khususnya QR Code, memiliki kapasitas penyimpanan data yang jauh lebih besar dibanding barcode 1D serta memiliki toleransi terhadap kerusakan fisik (*error correction*) yang lebih tinggi. Hal ini menjadikan QR Code sebagai pilihan yang lebih fleksibel untuk implementasi dalam sistem antrian berbasis web.

### 2.4.3 Fungsi Barcode dalam Sistem Antrian

Dalam konteks sistem antrian, barcode berfungsi sebagai media identifikasi tiket atau nomor antrian secara elektronik. Fungsi-fungsi utamanya meliputi:

1. **Identifikasi cepat**: Pasien cukup menunjukkan atau memindai tiket barcode untuk diverifikasi oleh sistem, tanpa perlu menginput nomor secara manual.
2. **Mengurangi kesalahan input**: Pemindaian barcode menghilangkan risiko salah ketik atau salah baca nomor antrian yang sering terjadi pada sistem manual.
3. **Mempercepat proses verifikasi**: Petugas Klaster dapat dengan cepat mengkonfirmasi kehadiran Pasien hanya dengan satu pemindaian.
4. **Dokumentasi otomatis**: Setiap pemindaian tercatat dalam sistem dengan stempel waktu (*timestamp*) yang akurat, sehingga data kedatangan–pemanggilan–penyelesaian terekam lengkap.
5. **Integrasi dengan sistem informasi**: Data barcode dapat langsung dihubungkan dengan informasi pasien, status antrian, dan rekam layanan dalam basis data.

Dalam penelitian ini, setiap Pasien yang berhasil mendaftar melalui antarmuka web akan menerima tiket digital yang memuat barcode unik. Barcode tersebut dipindai oleh Petugas Klaster pada saat Pasien dipanggil untuk dilayani, sehingga keakuratan data antrian terjaga dan seluruh proses terdokumentasi secara otomatis (Aidha Wardhani & Mustika Dewi, 2024).

---

## 2.5 Website

Website sebagai platform pengembangan sistem menawarkan berbagai keunggulan, terutama dalam hal aksesibilitas dan kemudahan pemeliharaan. Sistem antrian yang berbasis web memungkinkan seluruh pemangku kepentingan — Admin, Petugas Klaster, dan Pasien — mengakses sistem dari perangkat apa pun yang terhubung ke jaringan.

### 2.5.1 Pengertian Website

**Website** (situs web) adalah kumpulan halaman digital yang saling terhubung dan dapat diakses melalui internet atau intranet menggunakan protokol HTTP (*HyperText Transfer Protocol*) atau HTTPS (*HTTP Secure*). Setiap website memiliki alamat unik berupa **URL** (*Uniform Resource Locator*) dan diakses melalui perangkat lunak *browser* seperti Google Chrome, Mozilla Firefox, atau Microsoft Edge.

Website dibangun menggunakan kombinasi teknologi, antara lain:
- **HTML** (*HyperText Markup Language*): untuk struktur dan konten halaman.
- **CSS** (*Cascading Style Sheets*): untuk tampilan dan desain antarmuka.
- **JavaScript**: untuk interaktivitas dan dinamika di sisi klien.
- **Bahasa pemrograman server-side** (PHP, Python, Node.js, dll.): untuk logika bisnis dan pengelolaan data.
- **Basis data** (MySQL, PostgreSQL, dll.): untuk penyimpanan data secara terstruktur.

### 2.5.2 Jenis-Jenis Website

Berdasarkan karakteristik konten dan fungsinya, website dapat diklasifikasikan menjadi:

1. **Website Statis**: konten bersifat tetap dan jarang berubah; tidak memerlukan basis data. Cocok untuk halaman profil atau portofolio sederhana.
2. **Website Dinamis**: konten dihasilkan secara otomatis dari basis data berdasarkan permintaan pengguna. Sangat cocok untuk sistem informasi dan aplikasi manajemen.
3. **Website Transaksional**: website yang memfasilitasi transaksi seperti pembelian, pemesanan, atau pendaftaran online (contoh: e-commerce, e-booking).
4. **Aplikasi Web** (*Web Application*): sistem berbasis web yang mengelola proses bisnis kompleks secara terpusat, seperti sistem informasi manajemen, SaaS (*Software as a Service*), atau sistem antrian berbasis web.

### 2.5.3 Website Berbasis Sistem Informasi

**Aplikasi web berbasis sistem informasi** adalah jenis website dinamis yang berfungsi tidak hanya sebagai media publikasi, tetapi juga sebagai platform pengelolaan data dan proses bisnis secara terpusat. Seluruh logika bisnis, pemrosesan data, dan penyimpanan informasi dikelola di sisi server, sementara pengguna berinteraksi melalui antarmuka browser tanpa perlu menginstal perangkat lunak tambahan.

Keunggulan aplikasi web berbasis sistem informasi meliputi:
- **Aksesibilitas tinggi**: dapat diakses dari berbagai perangkat (komputer, tablet, smartphone) selama terhubung ke jaringan.
- **Pembaruan terpusat**: perubahan atau pembaruan sistem cukup dilakukan di server tanpa perlu memperbarui semua perangkat klien.
- **Integrasi mudah**: dapat dihubungkan dengan berbagai layanan dan API eksternal.
- **Skalabilitas**: dapat ditingkatkan kapasitasnya seiring pertumbuhan kebutuhan pengguna.
- **Pencatatan log otomatis**: seluruh aktivitas pengguna dapat direkam untuk keperluan audit dan analisis.

Dalam penelitian ini, sistem antrian dikembangkan sebagai aplikasi web berbasis sistem informasi yang mengintegrasikan manajemen antrian, pemindaian barcode, dan pelaporan data layanan dalam satu platform yang dapat diakses secara *real-time* oleh Admin, Petugas Klaster, maupun Pasien (Attabarok et al., 2025).

---

## 2.6 Metode Pengembangan Sistem

Metode pengembangan sistem (*System Development Life Cycle*/SDLC) adalah kerangka kerja terstruktur yang digunakan untuk merencanakan, merancang, mengimplementasikan, menguji, dan memelihara sebuah sistem informasi. Pemilihan metode yang tepat sangat bergantung pada karakteristik proyek, ketersediaan sumber daya, dan tingkat kepastian kebutuhan (*requirements*).

**Beberapa metode pengembangan sistem yang umum digunakan:**

**1. Waterfall (Air Terjun)**
Metode Waterfall adalah pendekatan sekuensial dan linier di mana setiap tahapan (analisis–desain–implementasi–pengujian–pemeliharaan) harus diselesaikan sebelum tahap berikutnya dimulai. Metode ini cocok untuk proyek dengan kebutuhan yang sudah jelas dan stabil sejak awal, namun kurang fleksibel terhadap perubahan kebutuhan di tengah pengembangan.

**2. Prototyping**
Metode *Prototyping* berfokus pada pembuatan prototipe awal secara cepat berdasarkan kebutuhan dasar pengguna, lalu secara iteratif menyempurnakannya berdasarkan umpan balik pengguna (*user feedback*). Pendekatan ini efektif ketika kebutuhan pengguna belum sepenuhnya terdefinisi di awal dan memerlukan proses eksplorasi bersama antara pengembang dan pengguna (Aidha Wardhani & Mustika Dewi, 2024).

**3. Agile/Scrum**
Pendekatan Agile adalah metode iteratif dan inkremental yang membagi pengembangan menjadi siklus pendek (*sprint*). Sangat cocok untuk proyek berskala besar dengan tim lintas fungsi dan perubahan kebutuhan yang sering terjadi.

**Metode yang digunakan dalam penelitian ini: Prototyping**

Penelitian ini mengadopsi metode *Prototyping* dengan pertimbangan sebagai berikut:
- Kebutuhan pengguna (Admin, Petugas Klaster, dan Pasien) perlu dieksplorasi dan divalidasi secara bertahap melalui proses konsultasi.
- Prototipe antarmuka sistem dapat ditunjukkan kepada pengguna untuk mendapatkan umpan balik nyata sebelum implementasi penuh.
- Metode ini memungkinkan penyesuaian desain sistem yang lebih responsif terhadap masukan dari pemangku kepentingan di lapangan.

Tahapan metode *Prototyping* yang diterapkan dalam penelitian ini mencakup: (1) identifikasi kebutuhan awal, (2) pengembangan prototipe, (3) evaluasi prototipe oleh pengguna, (4) penyempurnaan prototipe, dan (5) implementasi sistem final.

---

## 2.7 Penelitian Terdahulu

Tinjauan terhadap penelitian terdahulu dilakukan untuk memahami perkembangan ilmu pengetahuan yang relevan, mengidentifikasi celah penelitian (*research gap*), sekaligus memperkuat landasan teoritis bagi penelitian yang sedang dilaksanakan.

| No | Penulis & Tahun | Judul/Topik | Metode | Hasil Utama | Relevansi & Perbedaan |
|---|---|---|---|---|---|
| 1 | Aidha Wardhani & Mustika Dewi (2024) | Sistem informasi manajemen antrian berbasis web untuk layanan publik | Prototyping, pendekatan campuran | Pengembangan sistem antrian web yang meningkatkan efisiensi layanan dan kepuasan pengguna | Relevan sebagai referensi utama desain sistem antrian berbasis web; penelitian ini menambahkan komponen barcode dan integrasi FIFO secara digital |
| 2 | Attabarok et al. (2025) | Implementasi teknologi barcode pada sistem informasi layanan kesehatan | R&D, kuantitatif | Barcode terbukti mengurangi kesalahan input dan mempercepat verifikasi data pasien | Mendukung penggunaan barcode dalam penelitian ini; perbedaan pada integrasi dengan antrian dan peran pengguna yang lebih terstruktur (Admin, Petugas Klaster, Pasien) |
| 3 | *[Penulis, Tahun]* | *[Judul Penelitian 3 — diisi peneliti]* | *[Metode]* | *[Hasil utama]* | *[Relevansi dan perbedaan dengan penelitian ini]* |
| 4 | *[Penulis, Tahun]* | *[Judul Penelitian 4 — diisi peneliti]* | *[Metode]* | *[Hasil utama]* | *[Relevansi dan perbedaan dengan penelitian ini]* |
| 5 | *[Penulis, Tahun]* | *[Judul Penelitian 5 — diisi peneliti]* | *[Metode]* | *[Hasil utama]* | *[Relevansi dan perbedaan dengan penelitian ini]* |

Berdasarkan tinjauan di atas, dapat disimpulkan bahwa penelitian sebelumnya telah banyak membahas sistem antrian berbasis web maupun implementasi barcode secara terpisah. Penelitian ini berupaya mengintegrasikan kedua aspek tersebut — sistem antrian web dengan mekanisme barcode dan disiplin FIFO — dalam satu platform yang melibatkan tiga peran terstruktur (Admin, Petugas Klaster, dan Pasien), yang menjadi pembeda utama dari penelitian-penelitian terdahulu.

---

## 2.8 Kerangka Pemikiran

Kerangka pemikiran menggambarkan alur logis dan hubungan antar-konsep yang menjadi landasan penelitian ini. Berikut adalah uraian kerangka pemikiran yang digunakan:

**Identifikasi Masalah:**
- Proses antrian di *[nama instansi/fasilitas layanan — diisi peneliti]* masih dilakukan secara manual, mengakibatkan waktu tunggu yang lama dan tidak terukur.
- Tidak adanya dokumentasi digital menyulitkan evaluasi kinerja layanan.
- Potensi kesalahan pencatatan dan ketidakadilan urutan layanan cukup tinggi pada sistem manual.

**Kajian Teoritis:**
- Sistem Informasi (Aidha Wardhani & Mustika Dewi, 2024): menyediakan kerangka pengintegrasian data, prosedur, dan teknologi.
- Sistem Antrian & FIFO (Attabarok et al., 2025): memberikan landasan disiplin layanan yang adil dan terukur.
- Barcode: media identifikasi cepat dan akurat untuk tiket antrian digital.
- Website & Aplikasi Web: platform yang mudah diakses tanpa instalasi tambahan.
- Metode Prototyping: pendekatan pengembangan yang iteratif dan responsif terhadap kebutuhan pengguna.

**Solusi yang Dirancang:**
Mengembangkan **Sistem Antrian Berbasis Web dengan Barcode (FIFO)** yang melibatkan tiga peran utama:
- **Admin**: mengelola konfigurasi sistem, data pengguna, dan laporan kinerja antrian.
- **Petugas Klaster**: memanggil nomor antrian secara berurutan dan memindai barcode tiket Pasien.
- **Pasien**: mendaftar antrian secara online, menerima tiket barcode digital, dan memantau status antrian.

**Alur Penelitian:**
```
Identifikasi Masalah
       ↓
Studi Literatur & Pengumpulan Data
       ↓
Analisis Kebutuhan Sistem
       ↓
Perancangan Sistem (Flowchart, Use Case, ERD, UI)
       ↓
Implementasi (Pengkodean & Integrasi Barcode)
       ↓
Pengujian Sistem (Fungsional & Kinerja)
       ↓
Evaluasi & Pemeliharaan
       ↓
Kesimpulan
```

**Hasil yang Diharapkan:**
- Berkurangnya waktu tunggu rata-rata pasien secara signifikan dibandingkan sistem manual.
- Meningkatnya akurasi pencatatan data kedatangan dan layanan.
- Petugas Klaster dapat memantau dan mengelola antrian secara lebih efisien.
- Admin dapat menghasilkan laporan kinerja layanan secara otomatis dan akurat.

---

### Daftar Referensi Bab II

- Aidha Wardhani, & Mustika Dewi. (2024). *[Judul lengkap artikel — diisi peneliti]*. *[Nama Jurnal]*, *[Volume]*(Nomor), halaman. DOI/URL.
- Attabarok, *et al.* (2025). *[Judul lengkap artikel — diisi peneliti]*. *[Nama Jurnal]*, *[Volume]*(Nomor), halaman. DOI/URL.
