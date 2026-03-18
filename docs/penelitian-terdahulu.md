# 2.7 Penelitian Terdahulu

Bagian ini merangkum penelitian-penelitian yang relevan mengenai sistem antrian elektronik, penggunaan barcode/QR Code pada layanan, dan evaluasi metode FIFO. Setiap entri mencakup penulis & tahun, objek penelitian, metode yang digunakan, hasil utama, serta relevansinya dengan studi ini guna memetakan *gap* penelitian.

## Tabel 2.7 Penelitian Terdahulu

| No | Penulis & Tahun | Judul Penelitian | Metode | Hasil Penelitian | Relevansi dengan Studi Ini |
|----|-----------------|-----------------|--------|-----------------|---------------------------|
| 1 | Attabarok et al. (2025) | Sistem Informasi Pendaftaran Pasien Rawat Jalan Berbasis Web Menggunakan Metode Hot Fit Pada Puskesmas Subah Kabupaten Batang | Waterfall | Sistem mempermudah akses pasien ke layanan kesehatan dan memfasilitasi petugas dalam pencarian data rekam medis | Memberikan dasar rancangan pendaftaran pasien rawat jalan berbasis web pada Puskesmas; menjadi acuan alur registrasi digital |
| 2 | Krina Crisila T. Mawuntu et al. (2023) | Perancangan Sistem Antrian Berbasis Web Pada Puskesmas Pangolombian | Waterfall & RUP | Berhasil merancang aplikasi sistem antrian berbasis web menggunakan metode Rational Unified Process (RUP) dan dikembangkan dengan Waterfall | Memberikan referensi arsitektur sistem antrian berbasis web pada Puskesmas; antrian ditampilkan secara digital tanpa QR Code |
| 3 | Widarwati et al. (2024) | Pengembangan Sistem Antrian Berbasis Web Pada KEMENAG Kabupaten Pasuruan Menggunakan Metode Waterfall | Waterfall | Sistem berfungsi sesuai harapan dengan fitur pendaftaran pengguna, pemanggilan nomor antrian, rekap data antrian, dan pelaporan real-time | Menunjukkan efektivitas sistem antrian berbasis web dalam pengelolaan antrian instansi; menjadi pembanding fitur pelaporan real-time |
| 4 | Elvira & Maryam (2023) | Rancang Bangun Sistem Informasi Pemesanan Pemeriksaan dan Perawatan Gigi Berbasis Website | Waterfall | Pengujian SUS oleh 30 responden menghasilkan skor rata-rata 78 (grade C, rating *Good*); sistem layak dan mudah digunakan | Memberikan acuan pengujian usability (SUS) untuk evaluasi kemudahan penggunaan sistem berbasis web di layanan kesehatan |
| 5 | Fitriani et al. (2024) | Perancangan UML Sistem Registrasi Pasien Pada Rumah Sakit Bekasi Berbasis Web | SDLC | Sistem registrasi pasien berbasis web dengan pendekatan UML dan metode SDLC terbukti efektif meningkatkan efisiensi layanan kesehatan di RS Hermina Bekasi | Memberikan referensi pemodelan UML dan metode SDLC dalam perancangan sistem registrasi pasien di fasilitas kesehatan |

---

## Tabel 2.8 Perbedaan Penelitian Terdahulu dengan Penelitian Ini

Tabel berikut memetakan *gap* antara penelitian-penelitian terdahulu dan sistem **Antropusma** yang dikembangkan dalam studi ini.

| No | Penulis & Tahun | Fokus Penelitian Terdahulu | Penelitian Ini (Antropusma) | Perbedaan Utama |
|----|-----------------|---------------------------|----------------------------|-----------------|
| 1 | Attabarok et al. (2025) | Pendaftaran pasien rawat jalan berbasis web; evaluasi menggunakan metode Hot Fit | Sistem antrian elektronik berbasis web dengan QR Code & metode FIFO pada Puskesmas | Penelitian terdahulu berfokus pada manajemen rekam medis; Antropusma menambahkan penerbitan tiket QR Code sekali pakai dan antrian FIFO real-time |
| 2 | Mawuntu et al. (2023) | Perancangan sistem antrian berbasis web pada Puskesmas menggunakan RUP & Waterfall | Sistem antrian elektronik berbasis web dengan QR Code & metode FIFO pada Puskesmas | Penelitian terdahulu hanya menampilkan nomor antrian secara digital; Antropusma mengintegrasikan pemindaian QR Code oleh admin untuk validasi token satu kali pakai |
| 3 | Widarwati et al. (2024) | Sistem antrian berbasis web pada instansi pemerintah (KEMENAG) dengan pelaporan real-time | Sistem antrian elektronik berbasis web dengan QR Code & metode FIFO pada Puskesmas | Penelitian terdahulu tidak menggunakan barcode/QR Code; Antropusma menghasilkan QR Code unik per tiket dan mendukung scan barcode langsung oleh petugas |
| 4 | Elvira & Maryam (2023) | Sistem pemesanan layanan gigi berbasis website; diuji dengan SUS | Sistem antrian elektronik berbasis web dengan QR Code & metode FIFO pada Puskesmas | Penelitian terdahulu merupakan sistem perjanjian (appointment); Antropusma merupakan sistem antrian walk-in dengan FIFO dan tiket QR Code |
| 5 | Fitriani et al. (2024) | Perancangan UML sistem registrasi pasien di rumah sakit menggunakan SDLC | Sistem antrian elektronik berbasis web dengan QR Code & metode FIFO pada Puskesmas | Penelitian terdahulu hanya sampai pada tahap perancangan UML; Antropusma merupakan sistem yang diimplementasikan penuh dengan fitur QR Code, multi-jenis layanan (Dewasa & Lansia, Apotek, Laboratorium), dan antrian FIFO real-time |

### Keunggulan Spesifik Antropusma Dibandingkan Penelitian Terdahulu

| Fitur | Attabarok et al. (2025) | Mawuntu et al. (2023) | Widarwati et al. (2024) | Elvira & Maryam (2023) | Fitriani et al. (2024) | **Antropusma** |
|-------|:-----------------------:|:---------------------:|:-----------------------:|:----------------------:|:----------------------:|:--------------:|
| Pendaftaran antrian online | ✓ | ✓ | ✓ | ✓ | ✓ | ✓ |
| Nomor antrian otomatis | ✗ | ✓ | ✓ | ✗ | ✗ | ✓ |
| QR Code / Barcode pada tiket | ✗ | ✗ | ✗ | ✗ | ✗ | ✓ |
| Pemindaian QR Code oleh admin | ✗ | ✗ | ✗ | ✗ | ✗ | ✓ |
| Token sekali pakai (one-time use) | ✗ | ✗ | ✗ | ✗ | ✗ | ✓ |
| Metode antrian FIFO | ✗ | ✓ | ✓ | ✗ | ✗ | ✓ |
| Multi-jenis layanan | ✗ | ✗ | ✗ | ✗ | ✗ | ✓ |
| Status antrian real-time | ✗ | ✗ | ✓ | ✗ | ✗ | ✓ |
| Kedaluwarsa tiket otomatis | ✗ | ✗ | ✗ | ✗ | ✗ | ✓ |

> **Kesimpulan *gap* penelitian:** Penelitian-penelitian terdahulu belum mengintegrasikan mekanisme QR Code sekali pakai (*one-time token*) sebagai alat verifikasi antrian fisik pada Puskesmas. Antropusma mengisi gap tersebut dengan menggabungkan pendaftaran antrian online, penerbitan tiket QR Code unik, pemindaian barcode oleh petugas, serta manajemen antrian FIFO real-time dalam satu sistem berbasis web.

---

### Referensi

1. Attabarok, M., et al. (2025). Sistem Informasi Pendaftaran Pasien Rawat Jalan Berbasis Web Menggunakan Metode Hot Fit Pada Puskesmas Subah Kabupaten Batang. *Jurnal Informatika dan Rekayasa Perangkat Lunak* (atau prosiding terkait). *(Lengkapi volume, nomor, halaman, dan DOI sesuai sumber asli.)*
2. Mawuntu, K. C. T., et al. (2023). Perancangan Sistem Antrian Berbasis Web Pada Puskesmas Pangolombian. *Jurnal Teknik Informatika* (atau prosiding terkait). *(Lengkapi volume, nomor, halaman, dan DOI sesuai sumber asli.)*
3. Widarwati, et al. (2024). Pengembangan Sistem Antrian Berbasis Web Pada KEMENAG Kabupaten Pasuruan Menggunakan Metode Waterfall. *Jurnal Sistem Informasi* (atau prosiding terkait). *(Lengkapi volume, nomor, halaman, dan DOI sesuai sumber asli.)*
4. Elvira, & Maryam. (2023). Rancang Bangun Sistem Informasi Pemesanan Pemeriksaan dan Perawatan Gigi Berbasis Website. *Jurnal Kesehatan / Informatika Kesehatan* (atau prosiding terkait). *(Lengkapi volume, nomor, halaman, dan DOI sesuai sumber asli.)*
5. Fitriani, et al. (2024). Perancangan UML Sistem Registrasi Pasien Pada Rumah Sakit Bekasi Berbasis Web. *Jurnal Sistem Informasi Kesehatan / Prosiding SNIF* (atau prosiding terkait). *(Lengkapi volume, nomor, halaman, dan DOI sesuai sumber asli.)*

> **Catatan:** Lengkapi nama jurnal/prosiding, volume, nomor terbitan, halaman, dan tautan DOI/URL sesuai data publikasi asli untuk memenuhi standar sitasi akademik (APA/IEEE/Harvard).
