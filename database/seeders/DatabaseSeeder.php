<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Kategori;
use App\Models\Siswa;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        Admin::create([
            'username' => 'admin',
            'password' => Hash::make('admin123'),
        ]);

        // Siswas
        Siswa::create([
            'nis' => '1234567890',
            'kelas' => 'XII RPL 1',
            'password' => Hash::make('siswa123'),
        ]);

        Siswa::create([
            'nis' => '0987654321',
            'kelas' => 'XII RPL 2',
            'password' => Hash::make('siswa123'),
        ]);

        // Kategoris
        Kategori::create(['ket_kategori' => 'Kebersihan']);
        Kategori::create(['ket_kategori' => 'Kerusakan']);
        Kategori::create(['ket_kategori' => 'Fasilitas Kelas']);
        Kategori::create(['ket_kategori' => 'Fasilitas Olahraga']);
    }
}
