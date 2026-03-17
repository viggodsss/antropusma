# BAB II
# LANDASAN TEORI

---

## 2.1 Sistem Informasi

Sistem informasi merupakan kombinasi terorganisasi dari manusia, perangkat keras, perangkat lunak, data, prosedur, dan jaringan komunikasi yang bekerja secara terpadu untuk mengumpulkan, mengolah, menyimpan, dan mendistribusikan informasi guna mendukung operasi, manajemen, serta pengambilan keputusan dalam suatu organisasi. Dalam era digital saat ini, keberadaan sistem informasi menjadi sangat krusial karena membantu organisasi merespons perubahan lingkungan bisnis dengan lebih cepat dan akurat. Sistem informasi bukan sekadar teknologi, melainkan juga mencakup manusia dan prosedur yang berinteraksi untuk menghasilkan nilai dari data yang tersedia.

### 2.1.1 Pengertian Sistem

Sistem merupakan sekumpulan elemen atau komponen yang saling berinteraksi, berintegrasi, dan bekerja sama dalam satu kesatuan untuk mencapai tujuan tertentu. Alur kerja sistem mengikuti pola dasar **input–proses–output**, di mana setiap masukan diolah melalui mekanisme tertentu untuk menghasilkan keluaran yang bermakna bagi penggunanya.

Menurut konsep umum dalam ilmu komputer dan rekayasa perangkat lunak, sebuah sistem setidaknya memiliki elemen-elemen berikut:

- **Komponen (Component)**: bagian-bagian penyusun sistem yang memiliki fungsi masing-masing dan saling berhubungan.
- **Batas (Boundary)**: pemisah antara sistem dengan lingkungan di luarnya, yang menentukan ruang lingkup sistem.
- **Lingkungan (Environment)**: segala sesuatu di luar batas sistem yang dapat memengaruhi sistem.
- **Antarmuka (Interface)**: titik interaksi antara sistem dengan lingkungannya atau antarkomponen di dalam sistem.
- **Masukan (Input)**: energi, data, atau materi yang masuk ke dalam sistem untuk diproses.
- **Keluaran (Output)**: hasil dari proses yang disampaikan kepada pengguna atau sistem lain.
- **Penyimpanan (Storage)**: tempat data disimpan sementara maupun permanen.
- **Umpan Balik (Feedback)**: mekanisme pengendalian yang memungkinkan sistem mengevaluasi dan menyesuaikan kinerjanya.

Pemahaman tentang konsep sistem ini menjadi landasan dalam penelitian ini, karena sistem antrian berbasis web yang dikembangkan memiliki seluruh elemen di atas: komponen berupa modul Admin, Petugas Klaster, dan Pasien; batas sistem berupa otentikasi pengguna; masukan berupa data pendaftaran dan pemindaian barcode; serta keluaran berupa nomor antrian, status panggilan, dan laporan aktivitas.

### 2.1.2 Pengertian Informasi

Informasi adalah data yang telah diolah, diinterpretasikan, dan diberi makna sehingga dapat dipahami serta bermanfaat bagi penerimanya dalam proses pengambilan keputusan. Perbedaan mendasar antara data dan informasi terletak pada konteks dan nilai gunanya: data merupakan fakta mentah yang belum diproses, sedangkan informasi adalah hasil pemrosesan data tersebut.

Kualitas informasi sangat menentukan efektivitas penggunaan sistem informasi. Setidaknya terdapat lima dimensi kualitas informasi yang perlu diperhatikan:

1. **Akurasi (Accuracy)**: informasi bebas dari kesalahan dan mencerminkan kondisi nyata.
2. **Relevansi (Relevance)**: informasi sesuai dengan kebutuhan dan konteks pengambilan keputusan.
3. **Ketepatan Waktu (Timeliness)**: informasi tersedia saat dibutuhkan, tidak terlambat.
4. **Kelengkapan (Completeness)**: informasi mencakup semua aspek yang dibutuhkan tanpa ada yang terlewat.
5. **Konsistensi (Consistency)**: informasi tidak bertentangan dengan informasi lain yang relevan dan disajikan dalam format yang seragam.

Dalam konteks sistem antrian berbasis web ini, kualitas informasi diwujudkan melalui pencatatan nomor antrian yang akurat berkat pemindaian barcode, penyajian status antrian secara *real-time* (tepat waktu), serta pelaporan data layanan yang lengkap dan konsisten untuk keperluan evaluasi oleh Admin maupun Petugas Klaster.

### 2.1.3 Pengertian Sistem Informasi

Sistem informasi merupakan integrasi dari komponen manusia, prosedur, data, perangkat keras (*hardware*), perangkat lunak (*software*), dan jaringan komunikasi yang berfungsi untuk memfasilitasi aktivitas pengumpulan data (*input*), pemrosesan, penyimpanan, serta penyajian informasi kepada pengguna yang membutuhkannya.

Komponen utama sistem informasi mencakup:

- **Manusia (People)**: pengguna akhir dan pengelola sistem, dalam penelitian ini mencakup Admin, Petugas Klaster, dan Pasien.
- **Prosedur (Procedure)**: aturan dan alur kerja yang mengatur bagaimana sistem digunakan, misalnya alur pendaftaran antrian dan verifikasi barcode.
- **Data**: fakta dan angka yang dikumpulkan dan disimpan dalam basis data, seperti data identitas pasien, nomor antrian, dan waktu layanan.
- **Perangkat Keras (Hardware)**: infrastruktur fisik meliputi server, komputer, dan pemindai (*scanner*) barcode.
- **Perangkat Lunak (Software)**: aplikasi web yang dibangun untuk mengelola antrian, otentikasi peran, dan pelaporan.
- **Jaringan (Network)**: koneksi yang menghubungkan terminal-terminal layanan dengan server pusat agar data dapat diperbarui secara *real-time*.

Aktivitas utama yang dijalankan sistem informasi meliputi: pengumpulan dan entri data, pemrosesan dan transformasi data, penyimpanan dan pengambilan data, penyajian laporan dan notifikasi, serta pengendalian akses dan keamanan data.

Dalam penelitian ini, sistem informasi berperan sebagai sarana otomasi dan kontrol proses antrian. Dengan mengintegrasikan barcode sebagai media identifikasi dan antarmuka web sebagai sarana akses, sistem ini memastikan bahwa data antrian—mulai dari pendaftaran, panggilan, hingga penyelesaian layanan—tercatat, terpantau, dan dapat dilaporkan secara akurat kepada pemangku kepentingan.

---

## 2.2 Sistem Antrian

Sistem antrian adalah mekanisme terstruktur yang dirancang untuk mengelola entitas (dapat berupa orang, permintaan layanan, atau berkas) yang datang untuk mendapatkan pelayanan dari satu atau lebih fasilitas layanan. Tujuan utamanya adalah memastikan proses pelayanan berlangsung secara teratur, adil, dan efisien, sehingga waktu tunggu dapat diminimalkan dan kepuasan pengguna layanan meningkat. Dalam konteks layanan publik, seperti instansi kesehatan, antrian yang tidak dikelola dengan baik dapat menyebabkan kekacauan, ketidakpuasan, dan inefisiensi operasional.

### 2.2.1 Pengertian Sistem Antrian

Sistem antrian (*queueing system*) adalah suatu struktur yang terdiri atas serangkaian proses yang terjadi ketika pelanggan atau entitas datang untuk mendapatkan suatu layanan, menunggu jika server sedang sibuk, dan kemudian meninggalkan sistem setelah layanan selesai diberikan. Secara umum, sistem antrian terdiri atas empat elemen dasar:

1. **Kedatangan (Arrival)**: proses tibanya entitas ke dalam sistem, bisa bersifat acak atau terjadwal.
2. **Baris Tunggu (Queue)**: tempat entitas menunggu giliran, yang memiliki kapasitas tertentu (terbatas atau tidak terbatas).
3. **Fasilitas Pelayanan (Server)**: sumber daya yang memberikan layanan; dapat berupa satu atau beberapa loket/klaster.
4. **Kepergian (Departure)**: proses keluarnya entitas setelah mendapat layanan.

Sistem antrian yang baik tidak hanya mengurangi waktu tunggu, tetapi juga menyediakan mekanisme untuk memonitor dan mengevaluasi kinerja layanan secara berkelanjutan.

### 2.2.2 Tujuan Sistem Antrian

Penerapan sistem antrian dalam sebuah organisasi atau instansi bertujuan untuk:

1. **Mengurangi Waktu Tunggu**: dengan mengatur urutan pelayanan secara sistematis, waktu tunggu rata-rata setiap entitas dapat ditekan seminimal mungkin.
2. **Mengoptimalkan Utilisasi Server**: memastikan bahwa petugas atau fasilitas layanan tidak mengalami *idle* berlebihan maupun kelebihan beban (*overload*).
3. **Menjaga Keteraturan dan Keadilan**: entitas dilayani sesuai urutan yang jelas dan dapat dipertanggungjawabkan, sehingga tidak ada pihak yang merasa diperlakukan tidak adil.
4. **Menyediakan Data Kinerja**: sistem antrian yang terkomputerisasi menghasilkan data seperti *throughput* (jumlah layanan per satuan waktu), rata-rata waktu tunggu, dan tingkat pelayanan, yang dapat digunakan sebagai dasar evaluasi dan perbaikan berkelanjutan.
5. **Meningkatkan Kepuasan Pengguna**: pengalaman menunggu yang terstruktur dan transparan meningkatkan persepsi positif terhadap kualitas layanan.

Dalam sistem antrian berbasis web yang dikembangkan pada penelitian ini, kelima tujuan tersebut diwujudkan melalui pemberian nomor antrian otomatis berbasis barcode, pemantauan status antrian secara *real-time*, serta fitur pelaporan untuk Admin dan Petugas Klaster.

### 2.2.3 Komponen Sistem Antrian

Sistem antrian terdiri atas beberapa komponen utama yang saling berinteraksi, yaitu:

- **Sumber Kedatangan (*Calling Population*)**: populasi entitas yang berpotensi datang untuk dilayani. Dalam penelitian ini, sumber kedatangan adalah pasien yang terdaftar di sistem.
- **Proses Kedatangan (*Arrival Process*)**: pola atau jadwal kedatangan entitas, dapat bersifat acak (mengikuti distribusi tertentu) atau deterministik (terjadwal).
- **Disiplin Antrian (*Queue Discipline*)**: aturan yang menentukan urutan pelayanan. Pada penelitian ini digunakan disiplin FIFO (*First In First Out*), di mana pasien yang pertama terdaftar akan pertama dilayani.
- **Kapasitas Antrian (*Queue Capacity*)**: batas maksimum jumlah entitas yang dapat menunggu dalam antrian. Sistem ini menerapkan kapasitas dinamis yang dapat dikonfigurasi oleh Admin.
- **Fasilitas Pelayanan (*Service Facility*)**: dalam penelitian ini berupa klaster-klaster layanan yang dioperasikan oleh Petugas Klaster.
- **Waktu Pelayanan (*Service Time*)**: durasi yang dibutuhkan untuk melayani satu entitas. Data ini dicatat secara otomatis oleh sistem untuk keperluan evaluasi.
- **Metrik Kinerja (*Performance Metrics*)**: ukuran-ukuran seperti panjang antrian rata-rata, waktu tunggu rata-rata, dan tingkat utilisasi server yang dihasilkan oleh sistem untuk analisis dan pelaporan.

Pemahaman mendalam tentang komponen-komponen ini memungkinkan perancangan sistem yang optimal, di mana setiap komponen—dari pendaftaran pasien hingga pemanggilan nomor antrian—dirancang dengan mempertimbangkan efisiensi dan kemudahan penggunaan.

---

## 2.3 Metode Antrian

Metode antrian (disiplin antrian) menentukan urutan entitas dalam baris tunggu untuk menerima layanan. Pemilihan metode antrian yang tepat sangat memengaruhi tingkat keadilan, efisiensi, dan kepuasan dalam sistem pelayanan. Terdapat beberapa metode antrian yang umum dikenal, antara lain FIFO (*First In First Out*), LIFO (*Last In First Out*), SIRO (*Service In Random Order*), dan antrian berprioritas (*Priority Queueing*).

### 2.3.1 Metode First In First Out (FIFO)

FIFO adalah metode antrian yang melayani entitas berdasarkan urutan kedatangannya: entitas yang pertama kali tiba di sistem akan menjadi yang pertama mendapatkan layanan. Metode ini dikenal juga dengan istilah FCFS (*First Come First Served*) dan merupakan metode yang paling umum diterapkan dalam layanan publik.

**Keunggulan metode FIFO:**
- **Sederhana dan mudah diimplementasikan**: logika urutan berbasis waktu kedatangan tidak membutuhkan algoritma rumit.
- **Adil bagi semua pengguna**: setiap entitas diperlakukan setara tanpa diskriminasi berdasarkan faktor lain.
- **Transparan**: pengguna dapat dengan mudah memahami posisinya dalam antrian.
- **Meminimalkan rasa frustasi**: pengguna mengetahui bahwa mereka akan dilayani sesuai urutan kedatangan, mengurangi potensi konflik.

**Keterbatasan metode FIFO:**
- Tidak mempertimbangkan urgensi atau prioritas tertentu (misalnya kondisi darurat medis).
- Performa dapat menurun bila terjadi variasi waktu layanan yang signifikan antara satu entitas dengan entitas lainnya.
- Kurang fleksibel untuk situasi yang membutuhkan penanganan kasus mendesak secara khusus.

Metode FIFO dipilih dalam penelitian ini karena sistem antrian yang dikembangkan ditujukan untuk layanan berbasis registrasi terlebih dahulu. Pasien yang lebih awal melakukan registrasi dan memindai barcode tiketnya akan mendapatkan layanan lebih awal, sehingga tercipta keadilan dan keteraturan dalam proses pelayanan di setiap klaster.

---

## 2.4 Barcode

Teknologi barcode telah menjadi salah satu instrumen penting dalam otomasi sistem informasi modern. Kemampuannya untuk mengidentifikasi objek atau entitas secara cepat, akurat, dan tanpa kesalahan manual menjadikannya solusi yang efektif dalam berbagai domain, mulai dari manajemen inventori hingga sistem antrian layanan publik. Penelitian terdahulu menunjukkan bahwa integrasi barcode dalam sistem berbasis web secara signifikan meningkatkan akurasi dan kecepatan proses identifikasi dibandingkan dengan metode input manual (Aidha Wardhani & Mustika Dewi, 2024).

### 2.4.1 Pengertian Barcode

Barcode adalah representasi data dalam bentuk pola garis vertikal (barcode satu dimensi/1D) atau simbol dua dimensi (barcode 2D) yang dapat dibaca oleh pemindai (*scanner*) optik maupun kamera untuk mengidentifikasi objek secara cepat dan akurat. Barcode berfungsi sebagai jembatan antara dunia fisik dan sistem informasi digital: data yang tersandi dalam barcode dapat dibaca dan diterjemahkan secara instan oleh perangkat pembaca, kemudian diteruskan ke sistem komputer untuk diproses lebih lanjut.

Sebagai media otomatisasi identifikasi, barcode menyandikan data numerik dan/atau alfanumerik dalam pola visual yang diinterpretasikan oleh sensor optik dan diterjemahkan menjadi informasi digital yang dapat langsung diproses oleh aplikasi. Kecepatan dan akurasi pembacaan barcode menjadikannya pilihan yang lebih unggul dibandingkan entri data manual, khususnya dalam lingkungan dengan volume transaksi tinggi.

### 2.4.2 Jenis-Jenis Barcode

Barcode secara umum dibagi menjadi dua kategori utama berdasarkan dimensi penyandian datanya:

**Barcode Satu Dimensi (1D/Linear):**
- **UPC (*Universal Product Code*)**: digunakan secara luas dalam industri ritel untuk pelabelan produk konsumer.
- **EAN (*European Article Number*)**: standar internasional yang banyak dipakai di luar Amerika Serikat.
- **Code 39**: mendukung karakter alfanumerik, umum digunakan dalam logistik dan identifikasi industri.
- **Code 128**: kapasitas penyimpanan data lebih tinggi dari Code 39, mendukung seluruh karakter ASCII.

**Barcode Dua Dimensi (2D):**
- **QR Code (*Quick Response Code*)**: mampu menyimpan lebih banyak data (numerik, alfanumerik, biner) dan dapat dibaca dari berbagai sudut. QR Code juga memiliki kemampuan koreksi kesalahan (*error correction*) yang memungkinkan pembacaan tetap berhasil meski barcode mengalami kerusakan parsial.
- **Data Matrix**: ukuran kecil dengan kapasitas data tinggi, sering digunakan dalam industri elektronik dan farmasi.
- **PDF417**: barcode 2D berbentuk persegi panjang yang mampu menyimpan data dalam jumlah besar, digunakan dalam dokumen identitas dan tiket transportasi.

Barcode 2D, terutama QR Code, umumnya lebih unggul dibandingkan barcode 1D dalam hal kapasitas penyimpanan data, toleransi terhadap kerusakan fisik, dan kemudahan pembacaan menggunakan kamera *smartphone*. Dalam penelitian ini, barcode jenis QR Code dipertimbangkan sebagai media identifikasi tiket antrian karena kemudahan penggunaannya bagi pasien.

### 2.4.3 Fungsi Barcode dalam Sistem Antrian

Integrasi barcode ke dalam sistem antrian memberikan sejumlah manfaat operasional yang signifikan:

- **Identifikasi Cepat Tanpa Input Manual**: pemindaian barcode pada tiket antrian menggantikan proses entri nomor antrian secara manual, sehingga waktu pemrosesan per pasien dapat dikurangi secara drastis.
- **Pengurangan Kesalahan Pencatatan**: barcode meminimalkan potensi kesalahan yang biasanya terjadi pada proses input manual, seperti salah ketik nomor antrian atau identitas pasien.
- **Percepatan Proses Verifikasi**: Petugas Klaster dapat memverifikasi kedatangan pasien hanya dengan memindai barcode tiket, tanpa perlu mencari data secara manual di sistem.
- **Penyediaan Jejak Data (*Audit Trail*)**: setiap pemindaian barcode dicatat secara otomatis oleh sistem dengan *timestamp* yang akurat, sehingga tersedia rekam jejak lengkap untuk analisis performa layanan.
- **Peningkatan Pengalaman Pasien**: proses yang lebih cepat dan akurat mengurangi waktu tunggu dan meningkatkan kepuasan pasien terhadap kualitas layanan (Aidha Wardhani & Mustika Dewi, 2024).

Dalam sistem antrian berbasis web yang dikembangkan pada penelitian ini, barcode dicetak atau ditampilkan secara digital pada tiket antrian yang diperoleh pasien saat registrasi. Petugas Klaster menggunakan pemindai (*scanner*) yang terintegrasi dengan aplikasi web untuk memverifikasi kehadiran pasien, sehingga proses antrian berlangsung lebih efisien dan terstruktur.

---

## 2.5 Website

Website telah berkembang dari sekadar media publikasi informasi statis menjadi platform interaktif yang mendukung berbagai proses bisnis dan layanan publik. Kemampuan website untuk diakses dari berbagai perangkat melalui jaringan internet menjadikannya medium yang sangat fleksibel dan efisien untuk penerapan sistem informasi berbasis web.

### 2.5.1 Pengertian Website

Website (situs web) adalah kumpulan halaman informasi yang saling terhubung dan dapat diakses melalui internet atau jaringan intranet menggunakan protokol HTTP (*Hypertext Transfer Protocol*) atau HTTPS (*Hypertext Transfer Protocol Secure*). Setiap website diidentifikasi oleh sebuah alamat unik yang disebut URL (*Uniform Resource Locator*) dan dapat diakses menggunakan peramban web (*browser*) seperti Google Chrome, Mozilla Firefox, atau Microsoft Edge.

Secara teknis, website dibangun menggunakan teknologi *front-end* (HTML, CSS, JavaScript) untuk tampilan antarmuka pengguna dan teknologi *back-end* (bahasa pemrograman sisi server, basis data) untuk pemrosesan dan penyimpanan data. Kombinasi keduanya memungkinkan website berfungsi tidak hanya sebagai media informasi, tetapi juga sebagai platform layanan yang interaktif.

### 2.5.2 Jenis-Jenis Website

Berdasarkan karakteristik konten dan fungsinya, website dapat diklasifikasikan menjadi beberapa jenis:

- **Website Statis (*Static Website*)**: website yang menyajikan konten tetap yang jarang berubah. Konten dibuat langsung dalam file HTML tanpa keterlibatan basis data. Cocok untuk website profil pribadi atau landing page sederhana.
- **Website Dinamis (*Dynamic Website*)**: website yang kontennya dihasilkan secara otomatis dari basis data berdasarkan permintaan pengguna. Perubahan konten dapat dilakukan tanpa mengubah kode program secara langsung. Contoh: portal berita, sistem informasi manajemen.
- **Website Transaksional (*Transactional Website*)**: website yang mendukung transaksi elektronik, seperti pemesanan, pembayaran, atau pendaftaran layanan. Contoh: e-commerce, platform tiket online.
- **Aplikasi Web (*Web Application*)**: website yang berfungsi sebagai aplikasi perangkat lunak yang berjalan di peramban. Memiliki fungsionalitas yang kompleks dan interaktivitas tinggi, seperti sistem SaaS (*Software as a Service*), sistem informasi internal, atau sistem manajemen layanan.

Sistem antrian berbasis web yang dikembangkan dalam penelitian ini termasuk dalam kategori **aplikasi web** karena menyediakan fungsionalitas penuh untuk manajemen antrian, termasuk autentikasi pengguna dengan berbagai peran, pemrosesan data pendaftaran, serta pelaporan secara *real-time*.

### 2.5.3 Website Berbasis Sistem Informasi

Website berbasis sistem informasi adalah aplikasi web yang dirancang untuk mengelola data dan proses bisnis secara terpusat, dengan memanfaatkan arsitektur *client-server* di mana aplikasi berjalan di server dan diakses melalui antarmuka peramban oleh pengguna.

Keunggulan utama website berbasis sistem informasi dibandingkan aplikasi *desktop* konvensional antara lain:

- **Aksesibilitas Multi-Perangkat**: dapat diakses dari komputer, laptop, tablet, maupun *smartphone* tanpa perlu instalasi perangkat lunak khusus.
- **Pembaruan Terpusat**: pembaruan fitur atau perbaikan sistem dilakukan di server dan langsung berlaku bagi semua pengguna secara bersamaan.
- **Integrasi Mudah**: dapat diintegrasikan dengan layanan pihak ketiga melalui API (*Application Programming Interface*), seperti layanan notifikasi, pemindaian barcode, atau sistem autentikasi.
- **Kemudahan Pencatatan Log Aktivitas**: setiap interaksi pengguna dapat dicatat secara otomatis untuk keperluan *audit trail* dan analisis kinerja.
- **Skalabilitas**: sistem dapat dikembangkan dan disesuaikan kapasitasnya seiring dengan pertumbuhan jumlah pengguna.

Dalam konteks penelitian ini, website berbasis sistem informasi menjadi platform utama yang mengintegrasikan seluruh komponen sistem antrian—dari pendaftaran pasien, manajemen antrian oleh petugas, hingga pelaporan dan pemantauan oleh Admin—dalam satu antarmuka yang dapat diakses secara *real-time* oleh semua pemangku kepentingan (Attabarok et al., 2025).

---

## 2.6 Metode Pengembangan Sistem

Metode pengembangan sistem adalah kerangka kerja terstruktur yang digunakan sebagai panduan dalam proses perancangan, pembangunan, pengujian, dan penerapan sistem perangkat lunak. Pemilihan metode yang tepat sangat berpengaruh terhadap keberhasilan proyek, kualitas produk akhir, dan efisiensi penggunaan sumber daya yang tersedia.

Beberapa metode pengembangan sistem yang umum digunakan dalam penelitian skripsi di bidang informatika antara lain:

**1. Waterfall**
Metode Waterfall adalah pendekatan pengembangan sistem yang bersifat sekuensial dan terstruktur, di mana setiap tahap harus diselesaikan sepenuhnya sebelum tahap berikutnya dimulai. Tahapan utamanya meliputi: analisis kebutuhan → desain sistem → implementasi/pengkodean → pengujian → penerapan → pemeliharaan. Kelebihan metode ini adalah mudah dikelola dan didokumentasikan; kekurangannya adalah kurang fleksibel terhadap perubahan kebutuhan di tengah pengembangan.

**2. Prototyping**
Metode Prototyping adalah pendekatan iteratif di mana prototipe (versi awal) sistem dibangun secara cepat berdasarkan kebutuhan awal yang dikumpulkan, kemudian dievaluasi oleh pengguna, dan diperbaiki berdasarkan umpan balik yang diperoleh. Siklus ini berulang hingga prototipe dianggap memenuhi semua kebutuhan pengguna dan siap dikembangkan menjadi sistem final. Kelebihan utamanya adalah keterlibatan pengguna yang tinggi sejak awal, sehingga risiko ketidaksesuaian antara produk dengan kebutuhan pengguna dapat diminimalkan.

**3. Agile/Scrum**
Metode Agile adalah pendekatan pengembangan iteratif dan inkremental yang menekankan fleksibilitas, kolaborasi tim, dan respons cepat terhadap perubahan kebutuhan. Scrum sebagai salah satu framework Agile mengorganisasi pekerjaan ke dalam *sprint* (siklus kerja singkat, umumnya 1–4 minggu) dengan *product backlog*, *sprint planning*, *daily standup*, dan *sprint review*.

Dalam penelitian ini, metode pengembangan yang dipilih adalah **Prototyping**, dengan pertimbangan sebagai berikut: (1) kebutuhan pengguna (Admin, Petugas Klaster, Pasien) masih perlu digali secara bertahap melalui evaluasi prototipe; (2) proses iterasi memungkinkan penyesuaian antarmuka dan alur sistem berdasarkan umpan balik langsung dari pengguna nyata; dan (3) waktu pengembangan yang tersedia lebih cocok untuk pendekatan bertahap yang mengutamakan fungsionalitas inti terlebih dahulu. Metode Waterfall dipertimbangkan sebagai alternatif, namun dinilai kurang fleksibel mengingat kebutuhan yang masih dapat berkembang seiring berjalannya penelitian.

---

## 2.7 Penelitian Terdahulu

Beberapa penelitian terdahulu yang relevan dengan topik sistem antrian berbasis web, penggunaan barcode, dan metode FIFO telah dilakukan oleh berbagai peneliti. Penelitian-penelitian tersebut menjadi acuan penting dalam memposisikan penelitian ini di antara studi yang sudah ada, sekaligus mengidentifikasi celah (*gap*) yang perlu diisi.

**1. Aidha Wardhani & Mustika Dewi (2024)**
Penelitian ini mengkaji implementasi sistem antrian berbasis barcode pada instansi layanan publik. Hasil penelitian menunjukkan bahwa penggunaan barcode sebagai media identifikasi tiket antrian secara signifikan mengurangi kesalahan input data dan mempercepat proses verifikasi kehadiran. Sistem yang dikembangkan terbukti meningkatkan kepuasan pengguna layanan dibandingkan sistem antrian manual. Relevansi dengan penelitian ini: metode barcode yang digunakan sebagai basis identifikasi antrian, serta hasil evaluasi kepuasan pengguna, dijadikan referensi dalam perancangan dan pengujian sistem antrian berbasis web pada penelitian ini.

**2. Attabarok et al. (2025)**
Penelitian ini membahas pengembangan aplikasi web untuk manajemen antrian dengan penekanan pada aksesibilitas multi-perangkat dan efisiensi pengelolaan data layanan. Studi ini menunjukkan bahwa website berbasis sistem informasi yang terintegrasi dengan mekanisme antrian otomatis mampu meningkatkan efisiensi operasional secara signifikan. Relevansi dengan penelitian ini: pendekatan pengembangan berbasis web yang diusulkan Attabarok et al. (2025) mendasari arsitektur sistem yang dikembangkan, khususnya dalam hal pemisahan peran pengguna (Admin, Petugas, dan Pasien) serta mekanisme pemantauan antrian secara *real-time*.

*Catatan: Peneliti disarankan untuk melengkapi bagian ini dengan 3–5 penelitian terdahulu tambahan yang relevan, disertai tabel perbandingan mencakup kolom: Penulis/Tahun, Judul, Metode, Hasil Utama, dan Perbedaan/Gap dengan Penelitian Ini.*

---

## 2.8 Kerangka Pemikiran

Kerangka pemikiran merupakan peta konseptual yang menggambarkan alur logis penelitian: mulai dari identifikasi masalah, solusi yang diusulkan, langkah-langkah implementasi, hingga indikator keberhasilan yang diharapkan.

**Identifikasi Masalah:**
Proses antrian di instansi layanan publik seringkali masih dilakukan secara manual atau semi-manual, yang mengakibatkan: (1) waktu tunggu yang panjang dan tidak terprediksi; (2) potensi kesalahan pencatatan yang tinggi akibat entri data manual; (3) ketidaktransparanan urutan antrian yang memicu ketidakpuasan; dan (4) keterbatasan data historis untuk evaluasi kinerja layanan.

**Solusi yang Diusulkan:**
Merancang dan membangun sistem antrian berbasis web dengan barcode dan disiplin antrian FIFO, yang dapat diakses oleh tiga jenis pengguna dengan peran berbeda: Admin, Petugas Klaster, dan Pasien.

**Alur Penyelesaian Masalah:**
1. **Analisis Kebutuhan**: mengidentifikasi kebutuhan fungsional dan non-fungsional melalui wawancara, observasi, dan studi literatur.
2. **Perancangan Sistem**: merancang alur antrian, basis data, antarmuka pengguna, dan mekanisme integrasi barcode.
3. **Implementasi**: membangun aplikasi web berdasarkan hasil perancangan dengan menggunakan teknologi yang sesuai.
4. **Pengujian**: melakukan uji fungsionalitas, uji performa, dan uji penerimaan pengguna (*user acceptance test*).
5. **Evaluasi**: menganalisis hasil pengujian untuk mengukur efektivitas sistem dalam mengurangi waktu tunggu, meningkatkan akurasi data, dan meningkatkan kepuasan pengguna.

**Indikator Keberhasilan:**
- Penurunan rata-rata waktu tunggu pasien dibandingkan sistem sebelumnya.
- Pengurangan tingkat kesalahan input data pendaftaran antrian.
- Peningkatan skor kepuasan pengguna (Admin, Petugas Klaster, dan Pasien) berdasarkan instrumen evaluasi yang valid dan reliabel.
- Keberhasilan integrasi barcode dalam proses verifikasi kedatangan pasien di klaster layanan.

Alur kerangka pemikiran di atas dapat divisualisasikan dalam bentuk diagram yang menghubungkan elemen-elemen: masalah → teori pendukung (sistem informasi, antrian FIFO, barcode, website) → solusi (sistem antrian berbasis web) → pengujian dan evaluasi → hasil yang diharapkan.

---

*Daftar Pustaka (inline references used in this chapter):*
- Aidha Wardhani, & Mustika Dewi. (2024). *[Judul lengkap artikel — harap dilengkapi]*. *[Nama Jurnal]*, *[Volume]* (*[Nomor]*), *[Halaman]*.
- Attabarok, [nama depan], et al. (2025). *[Judul lengkap artikel — harap dilengkapi]*. *[Nama Jurnal/Prosiding]*, *[Volume]* (*[Nomor]*), *[Halaman]*.
