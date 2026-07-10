<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\ProfileSection;
use App\Models\Teacher;
use App\Models\Post;
use App\Models\Agenda;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\Download;

use App\Models\Category;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            // Create a sample editor user
            $editor = User::firstOrCreate(
                ['email' => 'editor@mt.sn'],
                [
                    'name' => 'Editor Madrasah',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            )->firstWhere('email', 'editor@mt.sn');

            $editor->assignRole('editor');

            // Create admin user if not exists
            $admin = User::firstOrCreate(
                ['email' => 'admin@mt.sn'],
                [
                    'name' => 'Administrator',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            )->firstWhere('email', 'admin@mt.sn');

            if (!$admin->hasRole('admin')) {
                $admin->assignRole('admin');
            }

            // Profile Sections
            ProfileSection::updateOrCreate(
                ['slug' => 'sejarah-madrasah'],
                [
                    'title' => 'Sejarah Madrasah',
                    'content' => 'MTsN 5 Tanah Laut didirikan pada tahun 2005 sebagai bagian dari upaya peningkatan kualitas pendidikan Islam di Kalimantan Selatan. Dengan semangat "Beriman, Berilmu, Berakhlak Mulia", madrasah kami terus berkembang menjadi lembaga pendidikan unggulan di tingkat Kabupaten Tanah Laut.',
                    'order' => 1,
                    'is_active' => true,
                ]
            );

            ProfileSection::updateOrCreate(
                ['slug' => 'visi-misi'],
                [
                    'title' => 'Visi dan Misi',
                    'content' => '<strong>Visi:</strong> Mewujudkan peserta didik yang beriman, berilmu, terampil, dan berakhlak mulia.<br><br><strong>Misi:</strong><br>1. Menjalankan pembelajaran berbasis nilai-nilai keislaman<br>2. Mengembangkan potensi akademik dan non-akademik siswa<br>3. Menciptakan lingkungan madrasah yang bersih, hijau, dan kondusif<br>4. Membangun kemitraan dengan masyarakat dan pemangku kepentingan',
                    'order' => 2,
                    'is_active' => true,
                ]
            );

            // Sample Teachers
            Teacher::create([
                'name' => 'Drs. Ahmad Fauzi, M.Pd.',
                'nip' => '198505152010011001',
                'position' => 'Kepala Madrasah',
                'education' => 'Magister Pendidikan',
                'contact' => '081234567890',
                'is_active' => true,
                'order' => 0,
            ]);

            Teacher::create([
                'name' => 'Siti Rahmawati, S.Pd.',
                'nip' => '199012102015032001',
                'position' => 'Guru Matematika',
                'education' => 'Sarjana Pendidikan',
                'contact' => '082345678901',
                'is_active' => true,
                'order' => 1,
            ]);

            Teacher::create([
                'name' => 'Muhammad Idris, S.Pd.I.',
                'nip' => '198807202012041002',
                'position' => 'Guru Agama Islam',
                'education' => 'Sarjana Pendidikan Islam',
                'contact' => '083456789012',
                'is_active' => true,
                'order' => 2,
            ]);

            Teacher::create([
                'name' => 'Nur Halizah, S.Pd.',
                'nip' => '199203152017012001',
                'position' => 'Guru Bahasa Inggris',
                'education' => 'Sarjana Pendidikan',
                'contact' => '084567890123',
                'is_active' => true,
                'order' => 3,
            ]);

            // Sample News Posts
            $newsPost1 = Post::create([
                'title' => 'Penerimaan Peserta Didik Baru (PPDB) 2026/2027 Dibuka',
                'slug' => 'penerimaan-peserta-didik-baru-ppdb-2026-2027-dibuka',
                'excerpt' => 'PPDB tahun ajaran baru 2026/2027 telah resmi dibuka. Simak informasi lengkap mengenai jadwal dan persyaratan pendaftaran.',
                'body' => 'MTsN 5 Tanah Laut membuka penerimaan peserta didik baru untuk tahun ajaran 2026/2027. Pendaftaran dibuka mulai bulan Juni hingga Juli 2026. Persyaratan meliputi: akta kelahiran, foto keluarga, rapor kelas 4-6 SD/MI, dan surat keterangan sehat. Untuk informasi lebih lanjut, silakan hubungi panitia PPDB atau kunjungi langsung kantor madrasah.',
                'content_type' => 'news',
                'is_published' => true,
                'published_at' => now()->subDays(5),
                'author_id' => $admin->id,
            ]);

            // Assign category
            $ppdbCategory = Category::firstOrCreate(
                ['slug' => 'ppdb'],
                ['name' => 'PPDB', 'color' => '#059669']
            );
            $newsPost1->categories()->sync([$ppdbCategory->id]);

            // Create Gallery category for auto-assignment in PostResource
            $galleryCategory = Category::firstOrCreate(
                ['slug' => 'gallery'],
                ['name' => 'Galeri', 'color' => '#6366f1']
            );

            $newsPost2 = Post::create([
                'title' => 'Juara Umum Lomba Pidato Tingkat Kabupaten Tanah Laut',
                'slug' => 'juara-umum-lomba-pidato-tingkat-kabupaten-tanah-laut',
                'excerpt' => 'Tim pidato MTsN 5 Tanah Laut berhasil meraih juara umum dalam lomba tingkat kabupaten.',
                'body' => 'Alhamdulillah, tim pidato MTsN 5 Tanah Laut berhasil meraih juara umum dalam lomba pidato tingkat kabupaten. Tiga peserta kami mendapat penghargaan: juara pertama, kedua, dan tiga. Prestasi ini merupakan bukti bahwa siswa-siswi kita memiliki potensi yang luar biasa.',
                'content_type' => 'news',
                'is_published' => true,
                'published_at' => now()->subDays(2),
                'author_id' => $admin->id,
            ]);

            $prestasiCategory = Category::firstOrCreate(
                ['slug' => 'prestasi'],
                ['name' => 'Prestasi', 'color' => '#d97706']
            );
            $newsPost2->categories()->sync([$prestasiCategory->id]);

            // Sample Gallery Posts
            Post::create([
                'title' => 'Upacara Bendera Minggu Ini',
                'slug' => 'upacara-bendera-minggu-ini',
                'excerpt' => 'Dokumentasi upacara bendera rutin hari Senin di halaman madrasah.',
                'body' => null,
                'content_type' => 'gallery',
                'is_published' => true,
                'published_at' => now()->subDays(3),
                'author_id' => $admin->id,
                'gallery_images' => [],
            ]);

            // Sample Agenda
            Agenda::create([
                'title' => 'Upacara Hari Senin - Kedisiplinan Siswa',
                'event_date' => now()->addWeeks(2),
                'event_time' => '07:00:00',
                'location' => 'Halaman Madrasah',
                'description' => 'Upacara bendera mingguan untuk meningkatkan semangat nasionalisme dan kedisiplinan siswa.',
                'category' => 'seremonial',
                'is_recurring' => true,
                'recurrence_pattern' => 'Mingguan',
            ]);

            Agenda::create([
                'title' => 'Kegiatan Pramuka',
                'event_date' => now()->addWeeks(1),
                'event_time' => '15:00:00',
                'location' => 'Lapangan Pramuka',
                'description' => 'Kegiatan rutin pramuka setiap hari Sabtu sore untuk melatih keterampilan outdoor dan kepemimpinan.',
                'category' => 'ekstrakurikuler',
                'is_recurring' => true,
                'recurrence_pattern' => 'Mingguan',
            ]);

            // Sample FAQs
            Faq::create([
                'question' => 'Bagaimana cara mendaftar PPDB?',
                'answer' => 'Pendaftaran PPDB dapat dilakukan secara online melalui website resmi madrasah atau datang langsung ke kantor madrasah. Siapkan dokumen yang diperlukan seperti akta kelahiran, foto keluarga, dan rapor SD/MI.',
                'category' => 'ppdb',
                'order' => 1,
                'is_active' => true,
            ]);

            Faq::create([
                'question' => 'Apa saja program ekstrakurikuler?',
                'answer' => 'Ekstrakurikuler yang tersedia meliputi: Pramuka, PMR, Olahraga (futsal, voli, pencak silat), Seni Qasidah, Rohis, Tahfidz Al-Quran, dan Bahasa Inggris.',
                'category' => 'kegiatan',
                'order' => 2,
                'is_active' => true,
            ]);

            Faq::create([
                'question' => 'Apakah tersedia program beasiswa?',
                'answer' => 'Ya, madrasah menyediakan program beasiswa bagi siswa berprestasi dan siswa kurang mampu. Informasi lengkap dapat diakses di kantor madrasah atau melalui website resmi.',
                'category' => 'keuangan',
                'order' => 3,
                'is_active' => true,
            ]);

            // Sample Galleries
            Gallery::create([
                'title' => 'Gedung Utama MTsN 5 Tanah Laut',
                'caption' => 'Tampak depan gedung utama madrasah',
                'image_path' => 'images/galleries/building.jpg',
                'album' => 'sarana',
                'order' => 1,
                'is_featured' => true,
                'is_active' => true,
            ]);

            Gallery::create([
                'title' => 'Kegiatan Pramuka',
                'caption' => 'Siswa-siswi mengikuti kegiatan pramuka',
                'image_path' => 'images/galleries/scout.jpg',
                'album' => 'kegiatan',
                'order' => 2,
                'is_featured' => false,
                'is_active' => true,
            ]);
        });
    }
}
