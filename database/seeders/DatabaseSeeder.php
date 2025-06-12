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
                'image' => 'nasi-goreng.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Sate Ayam',
                'slug' => Str::slug('sate-ayam'),
                'description' => 'Sate ayam dengan bumbu kacang.',
                'image' => 'sate-ayam.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Rendang Daging',
                'slug' => Str::slug('rendang-daging'),
                'description' => 'Rendang daging sapi yang empuk.',
                'image' => 'rendang-daging.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        Minuman::insert([
            [
                'name' => 'Es Teh',
                'slug' => Str::slug('es-teh'),
                'description' => 'Minuman segar dengan teh.',
                'image' => 'es-teh.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Es Jeruk',
                'slug' => Str::slug('es-jeruk'),
                'description' => 'Minuman segar dengan jeruk.',
                'image' => 'es-jeruk.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Es Kopi',
                'slug' => Str::slug('es-kopi'),
                'description' => 'Minuman segar dengan kopi.',
                'image' => 'es-kopi.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        Harga::insert([
            [
                'title' => 'Paket Spesial',
                'slug' => Str::slug('paket-spesial'),
                'description' => 'Paket spesial yang terdiri dari nasi goreng, es teh, dan kue cubit.',
                'price' => 1500000.00,
                'makanan_id' => 1,
                'minuman_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Paket Sate Ayam',
                'slug' => Str::slug('paket-sate-ayam'),
                'description' => 'Paket sate ayam dengan es jeruk dan puding coklat.',
                'price' => 1000000.00,
                'makanan_id' => 2,
                'minuman_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Paket Rendang Daging',
                'slug' => Str::slug('paket-rendang-daging'),
                'description' => 'Paket rendang daging dengan es kopi dan es krim vanila.',
                'price' => 500000.00,
                'makanan_id' => 3,
                'minuman_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Paket Nasi Goreng dan Es Teh',
                'slug' => Str::slug('paket-nasi-goreng-es-teh'),
                'description' => 'Paket nasi goreng dengan es teh.',
                'price' => 650000.00,
                'makanan_id' => 1,
                'minuman_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Paket Sate Ayam dan Es Jeruk',
                'slug' => Str::slug('paket-sate-ayam-es-jeruk'),
                'description' => 'Paket sate ayam dengan es jeruk.',
                'price' => 100000.00,
                'makanan_id' => 3,
                'minuman_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
