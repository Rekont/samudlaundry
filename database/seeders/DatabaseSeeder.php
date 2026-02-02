<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. BUAT LAYANAN (SERVICES)
        $services = [
            [
                'name' => 'Cuci Komplit Reguler',
                'price' => 7000,
                'description' => 'Cuci, Kering, Setrika. Selesai dalam 2-3 hari.',
            ],
            [
                'name' => 'Cuci Kilat Express',
                'price' => 12000,
                'description' => 'Selesai dalam 6 jam. Cocok untuk kebutuhan mendadak.',
            ],
            [
                'name' => 'Dry Cleaning Jas',
                'price' => 25000,
                'description' => 'Pencucian premium tanpa air untuk bahan jas/gaun.',
            ],
            [
                'name' => 'Setrika Saja',
                'price' => 5000,
                'description' => 'Hanya setrika dan pewangi premium.',
            ],
        ];

        foreach ($services as $s) {
            Service::create($s);
        }

        // 2. BUAT AKUN ADMIN (Bisa akses Filament)
        User::create([
            'name' => 'Owner SamudLaundry',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 3. BUAT AKUN CUSTOMER REGULER (Baru 2 transaksi)
        $budi = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        // Beri Budi 2 transaksi
        for ($i = 0; $i < 2; $i++) {
            Transaction::create([
                'user_id' => $budi->id,
                'service_id' => 1,
                'weight_or_qty' => 3,
                'total_price' => 21000,
                'status' => 'completed',
            ]);
        }

        // 4. BUAT AKUN CUSTOMER VIP (Sudah 6 transaksi)
        $siti = User::create([
            'name' => 'Siti Member',
            'email' => 'siti@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        // Beri Siti 6 transaksi completed agar otomatis jadi VIP
        for ($i = 0; $i < 6; $i++) {
            Transaction::create([
                'user_id' => $siti->id,
                'service_id' => 2,
                'weight_or_qty' => 2,
                'total_price' => 24000, // Harga normal tanpa diskon saat itu
                'status' => 'completed',
                'created_at' => now()->subDays($i + 1),
            ]);
        }
    }
}