<?php

namespace Database\Seeders;

use App\Models\Makanan;
use App\Models\Minuman;
use App\Models\Tenant;
use App\Models\User;
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
        // ===== Tenants =====
        $warungNusantara = Tenant::create([
            'name' => 'Warung Nusantara',
            'slug' => 'warung-nusantara',
            'description' => 'Makanan berat khas nusantara, masakan rumahan.',
            'is_active' => true,
        ]);

        $jajananPasundan = Tenant::create([
            'name' => 'Jajanan Pasundan',
            'slug' => 'jajanan-pasundan',
            'description' => 'Aneka jajanan pasar dan gorengan.',
            'is_active' => true,
        ]);

        $minumanSegar = Tenant::create([
            'name' => 'Minuman Segar',
            'slug' => 'minuman-segar',
            'description' => 'Es teh, es jeruk, kopi, dan minuman segar lainnya.',
            'is_active' => true,
        ]);

        // ===== Users =====
        User::create([
            'name' => 'deas',
            'phone' => '081234567890',
            'email' => '081234567890@placeholder.local',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'rira',
            'phone' => '081234567891',
            'email' => '081234567891@placeholder.local',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'admin',
            'phone' => '081234567892',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Kasir tenant
        User::create([
            'name' => 'Kasir Warung Nusantara',
            'phone' => '081234567893',
            'email' => 'warung@njajan.com',
            'password' => bcrypt('password'),
            'role' => 'tenant',
            'tenant_id' => $warungNusantara->id,
        ]);

        User::create([
            'name' => 'Kasir Jajanan Pasundan',
            'phone' => '081234567894',
            'email' => 'jajanan@njajan.com',
            'password' => bcrypt('password'),
            'role' => 'tenant',
            'tenant_id' => $jajananPasundan->id,
        ]);

        User::create([
            'name' => 'Kasir Minuman Segar',
            'phone' => '081234567895',
            'email' => 'minuman@njajan.com',
            'password' => bcrypt('password'),
            'role' => 'tenant',
            'tenant_id' => $minumanSegar->id,
        ]);

        // ===== Makanan (makanan berat + jajanan) =====
        Makanan::create([
            'name' => 'Nasi Goreng',
            'slug' => Str::slug('nasi-goreng') . '-' . Str::lower(Str::random(4)),
            'description' => 'Nasi goreng dengan bumbu spesial.',
            'image' => 'https://awsimages.detik.net.id/community/media/visual/2020/08/18/nasi-goreng-pedas_43.jpeg?w=600&q=90',
            'category' => 'makanan',
            'price' => 15000.00,
            'region' => 'Jawa',
            'tenant_id' => $warungNusantara->id,
            'is_available' => true,
        ]);

        Makanan::create([
            'name' => 'Sate Ayam',
            'slug' => Str::slug('sate-ayam') . '-' . Str::lower(Str::random(4)),
            'description' => 'Sate ayam dengan bumbu kacang.',
            'image' => 'https://png.pngtree.com/thumb_back/fh260/background/20240403/pngtree-chicken-satay-or-sate-ayam-served-with-lontong-rice-cake-and-image_15650302.jpg',
            'category' => 'makanan',
            'price' => 20000.00,
            'region' => 'Jawa',
            'tenant_id' => $warungNusantara->id,
            'is_available' => true,
        ]);

        Makanan::create([
            'name' => 'Rendang Daging',
            'slug' => Str::slug('rendang-daging') . '-' . Str::lower(Str::random(4)),
            'description' => 'Rendang daging sapi yang empuk.',
            'image' => 'https://www.frisianflag.com/storage/app/media/uploaded-files/rendang-padang.jpg',
            'category' => 'makanan',
            'price' => 25000.00,
            'region' => 'Sumatera',
            'tenant_id' => $warungNusantara->id,
            'is_available' => true,
        ]);

        Makanan::create([
            'name' => 'Cilok Bumbu Kacang',
            'slug' => Str::slug('cilok-bumbu-kacang') . '-' . Str::lower(Str::random(4)),
            'description' => 'Cilok kenyal dengan bumbu kacang pedas.',
            'image' => 'https://asset.kompas.com/crops/6FAZPT3TLfNpGZ4aH5oA0BOnJxA=/0x0:1000x667/750x500/data/photo/2021/03/31/6063872d8e94a.jpg',
            'category' => 'jajanan',
            'price' => 8000.00,
            'region' => 'Sunda',
            'tenant_id' => $jajananPasundan->id,
            'is_available' => true,
        ]);

        Makanan::create([
            'name' => 'Pisang Goreng',
            'slug' => Str::slug('pisang-goreng') . '-' . Str::lower(Str::random(4)),
            'description' => 'Pisang goreng crispy manis.',
            'image' => 'https://asset.kompas.com/crops/YIAYGpniXTSRhwdwSMfnyG1wLSA=/0x0:1000x667/750x500/data/photo/2022/07/08/62c7b60b9f7fb.jpg',
            'category' => 'jajanan',
            'price' => 10000.00,
            'region' => 'Nusantara',
            'tenant_id' => $jajananPasundan->id,
            'is_available' => true,
        ]);

        Makanan::create([
            'name' => 'Cireng Bumbu Rujak',
            'slug' => Str::slug('cireng-bumbu-rujak') . '-' . Str::lower(Str::random(4)),
            'description' => 'Cireng isi dengan bumbu rujak pedas manis.',
            'image' => 'https://asset.kompas.com/crops/nU3T_BtsmPZSVGP3JS2VXCjRp6Y=/0x0:744x496/750x500/data/photo/2021/12/02/61a866d3d7ba8.jpg',
            'category' => 'jajanan',
            'price' => 8000.00,
            'region' => 'Sunda',
            'tenant_id' => $jajananPasundan->id,
            'is_available' => true,
        ]);

        // ===== Minuman =====
        Minuman::create([
            'name' => 'Es Teh',
            'slug' => Str::slug('es-teh') . '-' . Str::lower(Str::random(4)),
            'description' => 'Teh manis dingin segar.',
            'image' => 'https://png.pngtree.com/png-vector/20240519/ourlarge/pngtree-jumbo-iced-tea-hd-transparent-background-png-image_12495354.png',
            'price' => 5000.00,
            'region' => 'Jawa',
            'tenant_id' => $minumanSegar->id,
            'is_available' => true,
        ]);

        Minuman::create([
            'name' => 'Es Jeruk',
            'slug' => Str::slug('es-jeruk') . '-' . Str::lower(Str::random(4)),
            'description' => 'Jeruk peras segar dengan es.',
            'image' => 'https://cdn1-production-images-kly.akamaized.net/2bUdwGUydtL50AOEMnCHNkD7FYQ=/469x625/smart/filters:quality(75):strip_icc():format(webp)/kly-media-production/medias/4777522/original/071308500_1710839241-iced-orange-cocktail-table__2_.jpg',
            'price' => 7000.00,
            'region' => 'Jawa',
            'tenant_id' => $minumanSegar->id,
            'is_available' => true,
        ]);

        Minuman::create([
            'name' => 'Es Kopi Susu',
            'slug' => Str::slug('es-kopi-susu') . '-' . Str::lower(Str::random(4)),
            'description' => 'Kopi susu gula aren.',
            'image' => 'https://png.pngtree.com/png-vector/20240615/ourlarge/pngtree-iced-milk-coffee-with-ice-cubes-png-image_12777358.png',
            'price' => 15000.00,
            'region' => 'Nusantara',
            'tenant_id' => $minumanSegar->id,
            'is_available' => true,
        ]);
    }
}
