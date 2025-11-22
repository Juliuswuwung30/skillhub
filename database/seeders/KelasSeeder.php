<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        Kelas::insert([
            [
                'judul' => 'Desain Grafis Dasar',
                'kode' => 'DG101',
                'pengajar' => 'Rina Kusuma',
                'deskripsi' => 'Belajar dasar desain menggunakan Adobe Photoshop & Illustrator.',
                'tanggal_mulai' => '2025-01-10',
                'tanggal_selesai' => '2025-04-10',
                'kapasitas' => 20,
            ],
            [
                'judul' => 'Pemrograman Dasar',
                'kode' => 'PD100',
                'pengajar' => 'Andi Pratama',
                'deskripsi' => 'Pengenalan logika pemrograman menggunakan Python untuk pemula.',
                'tanggal_mulai' => '2025-02-01',
                'tanggal_selesai' => '2025-06-01',
                'kapasitas' => 30,
            ],
            [
                'judul' => 'Editing Video Profesional',
                'kode' => 'EV200',
                'pengajar' => 'Satria Wijaya',
                'deskripsi' => 'Kelas video editing menggunakan Adobe Premiere Pro.',
                'tanggal_mulai' => '2025-01-20',
                'tanggal_selesai' => '2025-05-20',
                'kapasitas' => 15,
            ],
            [
                'judul' => 'Public Speaking Mastery',
                'kode' => 'PS150',
                'pengajar' => 'Dita Sari',
                'deskripsi' => 'Tingkatkan kemampuan berbicara di depan umum dengan percaya diri.',
                'tanggal_mulai' => '2025-03-01',
                'tanggal_selesai' => '2025-06-30',
                'kapasitas' => 25,
            ],
            [
                // kelas kapasitas kecil ⬇️
                'judul' => 'Photography Creative',
                'kode' => 'PH201',
                'pengajar' => 'Yusuf Hadi',
                'deskripsi' => 'Belajar teknik fotografi dasar hingga lanjutan.',
                'tanggal_mulai' => '2025-01-25',
                'tanggal_selesai' => '2025-05-25',
                'kapasitas' => 2,
            ],
            [
                'judul' => 'Digital Marketing',
                'kode' => 'DM300',
                'pengajar' => 'Laras Putri',
                'deskripsi' => 'Strategi pemasaran digital melalui media sosial dan SEO.',
                'tanggal_mulai' => '2025-04-01',
                'tanggal_selesai' => '2025-08-01',
                'kapasitas' => 2,
            ],
            [
                // kelas lewat waktu (tidak bisa diambil)
                'judul' => 'Data Analyst Bootcamp',
                'kode' => 'DA250',
                'pengajar' => 'Bambang Gunawan',
                'deskripsi' => 'Pengolahan data menggunakan SQL dan Python.',
                'tanggal_mulai' => '2024-01-01',
                'tanggal_selesai' => '2024-06-30',
                'kapasitas' => 30,
            ],
            [
                'judul' => 'UI/UX Design',
                'kode' => 'UX110',
                'pengajar' => 'Bella Kristian',
                'deskripsi' => 'Desain pengalaman pengguna dan pembuatan prototyping.',
                'tanggal_mulai' => '2025-02-15',
                'tanggal_selesai' => '2025-07-01',
                'kapasitas' => 25,
            ],
            [
                'judul' => 'Basic Networking',
                'kode' => 'NET101',
                'pengajar' => 'Rizky Ananda',
                'deskripsi' => 'Belajar dasar jaringan komputer dan konfigurasi perangkat.',
                'tanggal_mulai' => '2025-02-10',
                'tanggal_selesai' => '2025-06-15',
                'kapasitas' => 15,
            ],
            [
                'judul' => 'Microsoft Office Productivity',
                'kode' => 'MO202',
                'pengajar' => 'Novi Handayani',
                'deskripsi' => 'Kuasi Excel, Word, dan PowerPoint untuk dunia kerja.',
                'tanggal_mulai' => '2025-01-05',
                'tanggal_selesai' => '2025-05-05',
                'kapasitas' => 30,
            ],
        ]);
    }
}
