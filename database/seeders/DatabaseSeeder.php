<?php

namespace Database\Seeders;

use App\Models\Dessert;
use App\Models\Harga;
use App\Models\Makanan;
use App\Models\Minuman;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::insert([
            [
                'name' => 'deas',
                'email' => 'deas@example.com',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'role' => 'user',
            ],
            [
                'name' => 'rira',
                'email' => 'rira@example.com',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'role' => 'user',
            ],
            [
                'name' => 'admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'role' => 'admin',
            ],
        ]);

        Makanan::insert([
            [
                'name' => 'Nasi Goreng',
                'slug' => Str::slug('nasi-goreng'),
                'description' => 'Nasi goreng dengan bumbu spesial.',
                'image' => 'https://awsimages.detik.net.id/community/media/visual/2020/08/18/nasi-goreng-pedas_43.jpeg?w=600&q=90',
                'price' => 150000.00,
                'region' => 'Jawa',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Sate Ayam',
                'slug' => Str::slug('sate-ayam'),
                'description' => 'Sate ayam dengan bumbu kacang.',
                'image' => 'https://png.pngtree.com/thumb_back/fh260/background/20240403/pngtree-chicken-satay-or-sate-ayam-served-with-lontong-rice-cake-and-image_15650302.jpg',
                'price' => 100000.00,
                'region' => 'Jawa',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Rendang Daging',
                'slug' => Str::slug('rendang-daging'),
                'description' => 'Rendang daging sapi yang empuk.',
                'image' => 'https://www.frisianflag.com/storage/app/media/uploaded-files/rendang-padang.jpg',
                'price' => 200000.00,
                'region' => 'Sumatera',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        Minuman::insert([
            [
                'name' => 'Es Teh',
                'slug' => Str::slug('es-teh'),
                'description' => 'Minuman segar dengan teh.',
                'image' => 'https://png.pngtree.com/png-vector/20240519/ourlarge/pngtree-jumbo-iced-tea-hd-transparent-background-png-image_12495354.png',
                'price' => 10000.00,
                'region' => 'Jawa',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Es Jeruk',
                'slug' => Str::slug('es-jeruk'),
                'description' => 'Minuman segar dengan jeruk.',
                'image' => 'https://cdn1-production-images-kly.akamaized.net/2bUdwGUydtL50AOEMnCHNkD7FYQ=/469x625/smart/filters:quality(75):strip_icc():format(webp)/kly-media-production/medias/4777522/original/071308500_1710839241-iced-orange-cocktail-table__2_.jpg',
                'price' => 12000.00,
                'region' => 'Jawa',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Es Kopi',
                'slug' => Str::slug('es-kopi'),
                'description' => 'Minuman segar dengan kopi.',
                'image' => 'https://png.pngtree.com/png-vector/20240615/ourlarge/pngtree-iced-milk-coffee-with-ice-cubes-png-image_12777358.png',
                'price' => 15000.00,
                'region' => 'Jawa',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Harga::insert([
        //     [
        //         'title' => 'Paket Spesial',
        //         'slug' => Str::slug('paket-spesial'),
        //         'description' => 'Paket spesial yang terdiri dari nasi goreng, es teh, dan kue cubit.',
        //         'price' => 1500000.00,
        //         'makanan_id' => 1,
        //         'minuman_id' => 1,
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now(),
        //     ],
        //     [
        //         'title' => 'Paket Sate Ayam',
        //         'slug' => Str::slug('paket-sate-ayam'),
        //         'description' => 'Paket sate ayam dengan es jeruk dan puding coklat.',
        //         'price' => 1000000.00,
        //         'makanan_id' => 2,
        //         'minuman_id' => 2,
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now(),
        //     ],
        //     [
        //         'title' => 'Paket Rendang Daging',
        //         'slug' => Str::slug('paket-rendang-daging'),
        //         'description' => 'Paket rendang daging dengan es kopi dan es krim vanila.',
        //         'price' => 500000.00,
        //         'makanan_id' => 3,
        //         'minuman_id' => 3,
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now(),
        //     ],
        //     [
        //         'title' => 'Paket Nasi Goreng dan Es Teh',
        //         'slug' => Str::slug('paket-nasi-goreng-es-teh'),
        //         'description' => 'Paket nasi goreng dengan es teh.',
        //         'price' => 650000.00,
        //         'makanan_id' => 1,
        //         'minuman_id' => 2,
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now(),
        //     ],
        //     [
        //         'title' => 'Paket Sate Ayam dan Es Jeruk',
        //         'slug' => Str::slug('paket-sate-ayam-es-jeruk'),
        //         'description' => 'Paket sate ayam dengan es jeruk.',
        //         'price' => 100000.00,
        //         'makanan_id' => 3,
        //         'minuman_id' => 2,
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now(),
        //     ],
        // ]);
    }
}
