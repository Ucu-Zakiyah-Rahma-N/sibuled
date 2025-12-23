<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Perizinan;

class PerizinanSeeder extends Seeder
{
    public function run()
    {
        Perizinan::insert([
            ['jenis' => 'Sertifikat Laik Fungsi (SLF)', 'kode' => 'slf'],
            ['jenis' => 'Persetujuan Bangunan Gedung (PBG)', 'kode' => 'pbg'],
            ['jenis' => 'As Built Drawing', 'kode' => 'asbuilt'],
            ['jenis' => 'Analisa Struktur', 'kode' => 'analisa_struktur'],
            ['jenis' => 'Kelaikan Damkar', 'kode' => 'damkar'],
            ['jenis' => 'SLO Listrik', 'kode' => 'slo_listrik'],
            ['jenis' => 'SLO Genset', 'kode' => 'slo_genset'],
            ['jenis' => 'RPL RKL', 'kode' => 'rpl_rkl'],
            ['jenis' => 'UKL UPL', 'kode' => 'ukl_upl'],
            ['jenis' => 'RINTEK B3', 'kode' => 'rintek_b3'],
            ['jenis' => 'AMDAL', 'kode' => 'amdal'],
            ['jenis' => 'Laporan Per Semester', 'kode' => 'laporan_semester'],
            ['jenis' => 'Pertek Emisi', 'kode' => 'pertek_emisi'],
            ['jenis' => 'SLO Emisi', 'kode' => 'slo_emisi'],
            ['jenis' => 'Pertek Air Limbah', 'kode' => 'pertek_air'],
            ['jenis' => 'SLO Air', 'kode' => 'slo_air'],
            ['jenis' => 'Uji Laboratorium', 'kode' => 'uji_lab'],
            ['jenis' => 'ANDALALIN', 'kode' => 'andalalin'],
            ['jenis' => 'Pengesahan Siteplan', 'kode' => 'siteplan'],
            ['jenis' => 'KRK', 'kode' => 'krk'],
            ['jenis' => 'PKKPR', 'kode' => 'pkkpr'],
            ['jenis' => 'Perizinan OSS', 'kode' => 'oss'],
            ['jenis' => 'Riksa Uji K3 Alat', 'kode' => 'riksa_uji'],
            ['jenis' => 'Sertifikasi AK3U', 'kode' => 'ak3u'],
            ['jenis' => 'IPTB/SKK', 'kode' => 'iptb_skk'],
            ['jenis' => 'DED', 'kode' => 'ded'],
            ['jenis' => 'Pembangunan', 'kode' => 'pembangunan'],
            ['jenis' => 'Peil Banjir', 'kode' => 'peil_banjir'],
            ['jenis' => 'Kasosek', 'kode' => 'kasosek'],
            ['jenis' => 'Rekom Indag', 'kode' => 'rekom_indag'],
            ['jenis' => 'SHGB', 'kode' => 'shgb'],
            ['jenis' => 'Assessment Bangunan', 'kode' => 'assessment'],
            ['jenis' => 'TDG', 'kode' => 'tdg'],
        ]);
    }
}
