<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Produk;
use App\Models\ProdukKategori;
use App\Models\User;
use Illuminate\Database\Seeder;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        ProdukKategori::create([
            'nama' => 'DEVICE',
            'slug' => 'device'
        ]);
        ProdukKategori::create([
            'nama' => 'LIQUID FREEBASE',
            'slug' => 'liquid_freebase'
        ]);

        User::create([
            'nama' => 'Yuka Wardana',
            'jenis_kelamin' => 'Laki-Laki',
            'username' => 'yuka3vt',
            'telepon' => '0895377343574',
            'email' => 'yukawardana587@gmail.com',
            'password' => bcrypt('12345678'),
            'level' => 'admin',
            'akun' => 'aktif'
        ]);
        User::create([
            'nama' => 'Only One',
            'jenis_kelamin' => 'Laki-Laki',
            'username' => 'onlyone',
            'telepon' => '089537734357',
            'email' => 'onlyone08482@gmail.com',
            'password' => bcrypt('12345678'),
            'akun' => 'aktif'
        ]);
        Produk::create([
            'nama' => 'Thelema Quest SS Carbon Fiber',
            'slug' => 'thelema-quest-ss-carbon-fiber',
            'kategori_id' => 1,
            'harga' => 410500,
            'stok' => 8,
            'diskon' => 0,
            'dibeli' => 0,
            'hargaTotal' => 410500,
            'deskripsi' => 'Thelema Quest SS Carbon Fiber.......',
        ]);
        Produk::create([
            'nama' => 'Ambarita Back Bone Strawberry Trust 60ml 3mg',
            'slug' => 'ambarita-back-bone-strawberry-trust-60ml-3mg',
            'kategori_id' => 2,
            'harga' => 107500,
            'stok' => 1,
            'diskon' => 10,
            'dibeli' => 10,
            'hargaTotal' => 96750,
            'deskripsi' => 'Ambarita Back Bone Strawberry Trust 60ml 3mg.......',
        ]);

        $provinsis = RajaOngkir::provinsi()->all();
        foreach ($provinsis as $provinsi) {
            \App\Models\Provinsi::updateOrCreate(
                ['province_id' => $provinsi['province_id']],
                ['province' => $provinsi['province']]
            );
        }
        $kotas = RajaOngkir::kota()->all();
        foreach ($kotas as $kota) {
            \App\Models\Kota::updateOrCreate(
                ['city_id' => $kota['city_id']],
                [
                    'city_name' => $kota['city_name'],
                    'province_id' => $kota['province_id'],
                    'type' => $kota['type'] ?? null,
                    'postal_code' => $kota['postal_code'] ?? null
                ]
            );
        }
    }
}
