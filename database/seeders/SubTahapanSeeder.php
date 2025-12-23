<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tahapan;
use App\Models\SubTahapan;

class SubTahapanSeeder extends Seeder
{
    public function run()
    {
        $data = [];

        // Ambil ID Tahapan berdasarkan nama
        $surveyId = Tahapan::where('nama_tahapan', 'Survey')->value('id');
        $gambarId = Tahapan::where('nama_tahapan', 'Gambar')->value('id');

        // Sub untuk Tahapan Survey
        foreach (['Arsitektur', 'Struktur', 'MEP'] as $sub) {
            $data[] = [
                'tahapan_id' => $surveyId,
                'nama_sub' => $sub,
                'persentase_default' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Sub untuk Tahapan Gambar
        foreach (['Arsitektur', 'Struktur', 'MEP'] as $sub) {
            $data[] = [
                'tahapan_id' => $gambarId,
                'nama_sub' => $sub,
                'persentase_default' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        SubTahapan::insert($data);
    }
}
