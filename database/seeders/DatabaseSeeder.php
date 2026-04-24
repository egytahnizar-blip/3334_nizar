<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Event;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tambahkan User Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password123'),
        ]);

        // 2. Tambahkan 3 Kategori
        $cat1 = Category::create(['name' => 'Teknologi', 'slug' => 'teknologi']);
        $cat2 = Category::create(['name' => 'Olahraga', 'slug' => 'olahraga']);
        $cat3 = Category::create(['name' => 'Seni & Musik', 'slug' => 'seni-musik']);

        // 3. Tambahkan 6 Event (masing-masing kategori punya 2 event)

        // Event Kategori Teknologi
        Event::create([
            'category_id' => $cat1->id,
            'title' => 'Workshop Laravel 11 for Beginner',
            'description' => 'Belajar dasar-dasar framework Laravel terbaru.',
            'date' => '2026-05-20 09:00:00',
            'location' => 'Lab ICT Amikom',
            'price' => 50000,
            'stock' => 30,
        ]);

        Event::create([
            'category_id' => $cat1->id,
            'title' => 'AI & Future Tech Summit',
            'description' => 'Seminar nasional membahas masa depan AI.',
            'date' => '2026-06-15 13:00:00',
            'location' => 'Cinema Amikom',
            'price' => 75000,
            'stock' => 100,
        ]);

        // Event Kategori Olahraga
        Event::create([
            'category_id' => $cat2->id,
            'title' => 'Amikom Futsal Cup',
            'description' => 'Turnamen futsal antar program studi.',
            'date' => '2026-07-10 08:00:00',
            'location' => 'Lapangan GOR Amikom',
            'price' => 25000,
            'stock' => 20,
        ]);

        Event::create([
            'category_id' => $cat2->id,
            'title' => 'E-Sport Tournament Mobile Legends',
            'description' => 'Kompetisi MLBB tingkat universitas.',
            'date' => '2026-07-12 10:00:00',
            'location' => 'Basement Unit 3',
            'price' => 35000,
            'stock' => 64,
        ]);

        // Event Kategori Seni & Musik
        Event::create([
            'category_id' => $cat3->id,
            'title' => 'Gelar Budaya Nusantara',
            'description' => 'Pertunjukan tari dan musik tradisional.',
            'date' => '2026-08-05 19:00:00',
            'location' => 'Ruang Aula Amikom',
            'price' => 20000,
            'stock' => 150,
        ]);

        Event::create([
            'category_id' => $cat3->id,
            'title' => 'Music Fest: Indie Night',
            'description' => 'Konser musik indie lokal Yogyakarta.',
            'date' => '2026-08-20 20:00:00',
            'location' => 'Parkiran Belakang Unit 2',
            'price' => 100000,
            'stock' => 500,
        ]);
    }
}
