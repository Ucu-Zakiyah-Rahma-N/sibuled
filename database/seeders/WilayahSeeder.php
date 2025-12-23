<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Wilayah;

class WilayahSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('Memulai proses impor data provinsi dan kabupaten...');

        $provinces = Http::get('https://emsifa.github.io/api-wilayah-indonesia/api/provinces.json')->json();

        foreach ($provinces as $prov) {
            Wilayah::updateOrCreate(
                ['kode' => $prov['id']],
                [
                    'nama' => $prov['name'],
                    'jenis' => 'provinsi',
                    'parent_kode' => null
                ]
            );

            $regencies = Http::get("https://emsifa.github.io/api-wilayah-indonesia/api/regencies/{$prov['id']}.json")->json();

            foreach ($regencies as $kab) {
                Wilayah::updateOrCreate(
                    ['kode' => $kab['id']],
                    [
                        'nama' => $kab['name'],
                        'jenis' => 'kabupaten',
                        'parent_kode' => $prov['id']
                    ]
                );
            }
        }

        $this->command->info('Data provinsi dan kabupaten berhasil diimpor!');
    }
}
