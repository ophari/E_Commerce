<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        Brand::insert([
            [
                'name' => 'Rolex',
                'description' => 'Merek jam tangan mewah asal Swiss yang dikenal dengan ketahanan dan presisi tinggi. Rolex telah menjadi simbol status dan keanggunan sejak 1905.',
            ],
            [
                'name' => 'Omega',
                'description' => 'Brand jam tangan Swiss yang terkenal dengan inovasi teknologi dan desain elegan. Omega telah memproduksi jam untuk ekspedisi luar angkasa dan olahraga internasional.',
            ],
            [
                'name' => 'Seiko',
                'description' => 'Perusahaan Jepang yang memproduksi berbagai jenis jam tangan dari entry-level hingga high-end. Seiko dikenal dengan teknologi quartz dan automatic movement.',
            ],
            [
                'name' => 'Casio',
                'description' => 'Merek Jepang yang terkenal dengan jam tangan digital dan G-Shock yang tahan banting. Cocok untuk aktivitas outdoor dan gaya hidup aktif.',
            ],
            [
                'name' => 'Citizen',
                'description' => 'Brand Jepang yang inovatif dengan teknologi Eco-Drive yang bertenaga cahaya. Menawarkan kombinasi antara tradisi dan teknologi modern.',
            ],
        ]);
    }
}
