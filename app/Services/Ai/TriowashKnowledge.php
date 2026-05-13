<?php

namespace App\Services\Ai;

class TriowashKnowledge
{
    public static function businessProfile(): string
    {
        return <<<TEXT
Kamu adalah AI Customer Service Triowash Laundry.

Identitas bisnis:
- Nama: Triowash Laundry
- Lokasi: Banjarmasin, Kalimantan Selatan
- Jenis sistem: layanan manajemen laundry berbasis web responsif
- Pengguna: pelanggan dan admin/operator toko

Konsep utama Triowash:
- Pelanggan tidak wajib membuat akun.
- Pelanggan cukup memakai nama dan nomor telepon.
- Sistem mendukung pemesanan laundry jarak jauh.
- Sistem mendukung penggunaan langsung di toko.
- Sistem mendukung tracking pesanan tanpa login.
- Sistem mendukung pembayaran QRIS dan tunai.
- Pembayaran dilakukan setelah pakaian ditimbang agar lebih transparan.

Layanan utama:
1. Cuci Komplit
   Cuci, kering, setrika, dan lipat rapi.

2. Cuci Kering
   Cuci dan kering tanpa setrika.

3. Setrika Saja
   Untuk pakaian bersih yang hanya ingin dirapikan.

Pilihan wangi:
- Wangi Bunga
- Wangi Sport
- Wangi Original

Opsi layanan antar jemput:
- Dijemput dan diantar
- Dijemput saja
- Diantar saja
- Antar dan ambil sendiri

Status pesanan:
- menunggu_verifikasi: pesanan baru masuk dan menunggu ACC admin
- dijemput: admin menerima pesanan dan kurir menjemput pakaian
- diproses: pakaian sedang dicuci atau dikerjakan
- selesai: pengerjaan selesai
- diantar: pesanan dalam pengantaran
- selesai_diterima: pesanan sudah diterima pelanggan
- dibatalkan: pesanan dibatalkan

Pembayaran:
- QRIS untuk pelanggan jarak jauh
- Tunai untuk pelanggan walk-in
- Total harga dihitung setelah penimbangan aktual
- Sistem pembayaran bersifat transparan

Halaman penting:
- Pesan Laundry: /pesan
- Cek Pesanan: /periksa-pesanan
- AI Customer Service: /cs-ai

Aturan menjawab:
- Jawab sebagai AI Customer Service Triowash.
- Gunakan bahasa Indonesia yang ramah, sopan, dan mudah dipahami.
- Jangan menyebut diri sebagai ChatGPT.
- Jangan mengarang harga final jika belum ada data harga.
- Jika ditanya harga, jelaskan bahwa harga dihitung berdasarkan layanan, berat cucian, dan pilihan tambahan.
- Jika pelanggan ingin pesan, arahkan ke /pesan.
- Jika pelanggan ingin cek status, arahkan ke /periksa-pesanan.
- Jika pelanggan bertanya lama pengerjaan, jelaskan bahwa estimasi bergantung pada antrean, jenis layanan, dan berat cucian.
- Jika pertanyaan di luar konteks laundry, jawab singkat lalu arahkan kembali ke layanan Triowash.
TEXT;
    }

    public static function quickReplies(): array
    {
        return [
            'Apa saja layanan Triowash?',
            'Apakah bisa antar jemput?',
            'Bagaimana cara pesan laundry?',
            'Bagaimana cara cek pesanan?',
            'Berapa lama pengerjaan laundry?',
            'Metode pembayarannya apa saja?',
            'Apa maksud pembayaran setelah ditimbang?',
        ];
    }

    public static function localDataset(): array
    {
        return [
            'greeting' => [
                'keywords' => [
                    'halo',
                    'hai',
                    'hello',
                    'pagi',
                    'siang',
                    'sore',
                    'malam',
                    'assalamualaikum',
                    'permisi',
                ],
                'answer' => 'Halo! Saya AI Customer Service Triowash. Saya bisa bantu menjelaskan layanan laundry, cara pesan, antar jemput, pembayaran, estimasi pengerjaan, dan cek status pesanan.',
            ],

            'services' => [
                'keywords' => [
                    'layanan',
                    'jasa',
                    'paket',
                    'cuci',
                    'setrika',
                    'komplit',
                    'kering',
                    'lipat',
                    'apa saja layanan',
                    'layanan triowash',
                    'jenis layanan',
                ],
                'answer' => 'Triowash memiliki 3 layanan utama: Cuci Komplit, Cuci Kering, dan Setrika Saja. Cuci Komplit mencakup cuci, kering, setrika, dan lipat. Cuci Kering cocok untuk pakaian yang ingin dicuci dan dikeringkan tanpa setrika. Setrika Saja untuk pakaian bersih yang hanya ingin dirapikan.',
            ],

            'pickup_delivery' => [
                'keywords' => [
                    'antar',
                    'jemput',
                    'antar jemput',
                    'kurir',
                    'ambil',
                    'diantar',
                    'ongkir',
                    'rumah',
                    'kos',
                    'kost',
                    'dijemput',
                    'pengantaran',
                    'penjemputan',
                ],
                'answer' => 'Triowash mendukung layanan antar jemput. Pelanggan bisa memesan dari rumah atau kos, lalu kurir akan membantu proses pengambilan dan pengantaran sesuai opsi yang dipilih.',
            ],

            'order_how_to' => [
                'keywords' => [
                    'cara pesan',
                    'pesan',
                    'order',
                    'booking',
                    'form',
                    'pemesanan',
                    'mau laundry',
                    'ingin laundry',
                    'buat pesanan',
                    'pesan laundry',
                ],
                'answer' => 'Untuk memesan laundry, buka halaman Pesan Laundry. Isi nama, nomor telepon, alamat, link Google Maps jika ada, pilih layanan, pilihan wangi, dan opsi antar jemput. Setelah dikirim, pesanan akan masuk ke sistem untuk dikonfirmasi admin.',
                'cta' => [
                    'label' => 'Buka Halaman Pesan',
                    'url' => '/pesan',
                ],
            ],

            'tracking' => [
                'keywords' => [
                    'cek',
                    'status',
                    'tracking',
                    'pesanan saya',
                    'sudah selesai',
                    'nomor pesanan',
                    'periksa',
                    'cek pesanan',
                    'lacak pesanan',
                    'status laundry',
                ],
                'answer' => 'Untuk mengecek pesanan, buka halaman Periksa Pesanan. Pelanggan cukup memasukkan nama dan nomor telepon yang digunakan saat pemesanan. Sistem akan menampilkan status pesanan seperti menunggu verifikasi, dijemput, diproses, selesai, diantar, atau selesai diterima.',
                'cta' => [
                    'label' => 'Cek Pesanan',
                    'url' => '/periksa-pesanan',
                ],
            ],

            'payment' => [
                'keywords' => [
                    'bayar',
                    'pembayaran',
                    'qris',
                    'qr',
                    'tunai',
                    'cash',
                    'transfer',
                    'lunas',
                    'unpaid',
                    'paid',
                    'metode pembayaran',
                    'cara bayar',
                ],
                'answer' => 'Triowash mendukung pembayaran QRIS dan tunai. Pembayaran dilakukan setelah cucian ditimbang agar total harga lebih transparan dan sesuai berat aktual.',
            ],

            'post_payment' => [
                'keywords' => [
                    'setelah ditimbang',
                    'ditimbang',
                    'berat',
                    'harga akhir',
                    'estimasi harga',
                    'transparan',
                    'post payment',
                    'bayar nanti',
                    'berat aktual',
                ],
                'answer' => 'Triowash menggunakan sistem pembayaran setelah penimbangan aktual. Jadi total harga dihitung setelah pakaian sampai di toko dan berat cucian diketahui. Cara ini membuat tagihan lebih akurat dan transparan.',
            ],

            'no_account' => [
                'keywords' => [
                    'akun',
                    'login',
                    'register',
                    'daftar',
                    'tanpa akun',
                    'password',
                    'verifikasi',
                    'harus login',
                    'buat akun',
                ],
                'answer' => 'Pelanggan Triowash tidak perlu membuat akun. Pemesanan dan pengecekan pesanan cukup menggunakan nama dan nomor telepon.',
            ],

            'status_flow' => [
                'keywords' => [
                    'alur',
                    'status pesanan',
                    'menunggu',
                    'dijemput',
                    'diproses',
                    'selesai',
                    'diantar',
                    'diterima',
                    'menunggu verifikasi',
                    'selesai diterima',
                ],
                'answer' => 'Alur status pesanan Triowash adalah: menunggu verifikasi, dijemput, diproses, selesai, diantar, dan selesai diterima. Jika ada kendala, pesanan juga bisa dibatalkan.',
            ],

            'perfume' => [
                'keywords' => [
                    'wangi',
                    'parfum',
                    'bunga',
                    'sport',
                    'original',
                    'pewangi',
                    'pilihan wangi',
                    'aroma',
                ],
                'answer' => 'Triowash menyediakan pilihan wangi seperti Wangi Bunga, Wangi Sport, dan Wangi Original. Pilihan ini bisa disesuaikan saat melakukan pemesanan.',
            ],

            'admin' => [
                'keywords' => [
                    'admin',
                    'dashboard',
                    'operator',
                    'acc',
                    'kelola',
                    'manajemen',
                    'status',
                    'kasir',
                    'tablet',
                    'toko',
                ],
                'answer' => 'Admin Triowash dapat mengelola pesanan masuk, mengonfirmasi pesanan, memperbarui status, memasukkan berat cucian, menghitung total harga, dan mencatat pembayaran.',
            ],

            'price' => [
                'keywords' => [
                    'harga',
                    'biaya',
                    'tarif',
                    'berapa',
                    'ongkos',
                    'total',
                    'murah',
                    'mahal',
                    'price',
                    'harga laundry',
                ],
                'answer' => 'Harga laundry dihitung berdasarkan jenis layanan, berat cucian, dan pilihan tambahan seperti wangi. Karena Triowash menggunakan penimbangan aktual, total harga final akan diketahui setelah pakaian ditimbang di toko.',
            ],

            'duration' => [
                'keywords' => [
                    'lama',
                    'berapa lama',
                    'pengerjaan',
                    'lama pengerjaan',
                    'lama pengerjaan laundry',
                    'laundry selesai',
                    'kapan selesai',
                    'estimasi',
                    'estimasi selesai',
                    'waktu',
                    'waktu pengerjaan',
                    'durasi',
                    'proses',
                    'proses laundry',
                    'selesai',
                    'berapa hari',
                    'berapa jam',
                    'butuh berapa lama',
                    'kapan bisa diambil',
                    'kapan diantar',
                    'cepat selesai',
                ],
                'answer' => 'Estimasi pengerjaan laundry di Triowash bergantung pada jenis layanan, jumlah antrean, dan berat cucian. Secara umum, pesanan diproses setelah pakaian diterima dan ditimbang oleh admin. Untuk mengetahui perkembangan terbaru, pelanggan bisa memantau status melalui halaman Periksa Pesanan.',
                'cta' => [
                    'label' => 'Cek Pesanan',
                    'url' => '/periksa-pesanan',
                ],
            ],

            'location' => [
                'keywords' => [
                    'lokasi',
                    'alamat',
                    'dimana',
                    'di mana',
                    'banjarmasin',
                    'toko',
                    'tempat',
                    'maps',
                    'google maps',
                ],
                'answer' => 'Triowash Laundry berlokasi di Banjarmasin, Kalimantan Selatan. Untuk pemesanan jarak jauh, pelanggan dapat mencantumkan alamat lengkap dan link Google Maps agar proses antar jemput lebih mudah.',
            ],

            'qris' => [
                'keywords' => [
                    'qris',
                    'qr code',
                    'scan',
                    'scan qris',
                    'pembayaran digital',
                    'e-wallet',
                    'dompet digital',
                ],
                'answer' => 'Pembayaran QRIS digunakan untuk memudahkan pelanggan jarak jauh. Setelah pakaian ditimbang dan total harga dihitung, pelanggan dapat melakukan pembayaran melalui QRIS sesuai instruksi pada sistem.',
            ],

            'cancel' => [
                'keywords' => [
                    'batal',
                    'batalkan',
                    'dibatalkan',
                    'cancel',
                    'membatalkan',
                    'pesanan batal',
                ],
                'answer' => 'Pesanan dapat dibatalkan jika masih memungkinkan dan belum masuk proses tertentu. Untuk memastikan, pelanggan dapat menghubungi admin atau mengecek status pesanan terlebih dahulu melalui halaman Periksa Pesanan.',
                'cta' => [
                    'label' => 'Cek Pesanan',
                    'url' => '/periksa-pesanan',
                ],
            ],

            'unknown' => [
                'keywords' => [],
                'answer' => 'Maaf, saya belum menemukan informasi yang tepat. Saya bisa membantu menjelaskan layanan Triowash, cara pesan, antar jemput, pembayaran, estimasi pengerjaan, dan cek status pesanan.',
            ],
        ];
    }
}