<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use Carbon\Carbon;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        $articles = [
            [
                'title' => 'Mengenal Ganoderma: Penyakit Jamur yang Mengancam Kelapa Sawit',
                'slug' => 'mengenal-ganoderma-penyakit-jamur',
                'author' => 'Tim Ganodetect',
                'image' => 'article1.jpg',
                'excerpt' => 'Ganoderma adalah salah satu jamur yang dapat menyebabkan penyakit fatal pada pohon kelapa sawit — mengenali gejala dini sangat krusial.',
                'body' => view('seed_contents.article1')->render(),
                'published_at' => $now->subDays(10),
            ],
            [
                'title' => 'Cara Deteksi Dini Ganoderma Menggunakan Teknologi Drone',
                'slug' => 'deteksi-dini-ganoderma-dengan-drone',
                'author' => 'Tim Ganodetect',
                'image' => 'article2.jpg',
                'excerpt' => 'Deteksi menggunakan drone dan analisis citra membantu menemukan tanda-tanda awal infeksi Ganoderma sehingga upaya pengendalian bisa dilakukan lebih cepat.',
                'body' => view('seed_contents.article2')->render(),
                'published_at' => $now->subDays(7),
            ],
            [
                'title' => 'Manajemen Lapangan untuk Mencegah Penyebaran Ganoderma',
                'slug' => 'manajemen-lapangan-mencegah-ganoderma',
                'author' => 'Tim Ganodetect',
                'image' => 'article3.jpg',
                'excerpt' => 'Perbaikan drainase, sanitasi, dan rotasi tanaman adalah langkah-langkah penting untuk mengurangi risiko penyebaran Ganoderma.',
                'body' => view('seed_contents.article3')->render(),
                'published_at' => $now->subDays(5),
            ],
            [
                'title' => 'Pengobatan & Rekomendasi Teknologi: Mengurangi Dampak Ganoderma',
                'slug' => 'pengobatan-rekomendasi-teknologi-ganoderma',
                'author' => 'Tim Ganodetect',
                'image' => 'article4.jpg',
                'excerpt' => 'Berbagai metode ada untuk mengurangi dampak Ganoderma — dari solusi biologis hingga monitoring berkala dengan sensor dan drone.',
                'body' => view('seed_contents.article4')->render(),
                'published_at' => $now->subDays(2),
            ],
        ];

        foreach ($articles as $a) {
            Article::updateOrCreate(['slug' => $a['slug']], $a);
        }
    }
}