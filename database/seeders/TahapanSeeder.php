<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tahapan;

class TahapanSeeder extends Seeder
{
    public function run()
    {
        Tahapan::insert([
            ['nama_tahapan' => 'Collect Dokumen'],
            ['nama_tahapan' => 'Screening Dokumen'],
            ['nama_tahapan' => 'Surat Permohonan'],
            ['nama_tahapan' => 'Surat Komitmen'],
            ['nama_tahapan' => 'Peta Polygon'],
            ['nama_tahapan' => 'Survey'],
            ['nama_tahapan' => 'Tinjauan Lokasi'],
            ['nama_tahapan' => 'Pengkajian Teknis'],
            ['nama_tahapan' => 'Pembuatan Kajian Laporan Semester'],
            ['nama_tahapan' => 'Pembuatan Kajian Assessment dan RAB'],
            ['nama_tahapan' => 'Penyusunan Laporan Hasil Pemeriksaan'],
            ['nama_tahapan' => 'Pengesahan Siteplan'],
            ['nama_tahapan' => 'Konsultasi Dinas'],
            ['nama_tahapan' => 'Konsultasi Dinas 1'],
            ['nama_tahapan' => 'Konsultasi Dinas 2'],
            ['nama_tahapan' => 'Submit SIMBG'],
            ['nama_tahapan' => 'Submit Dokumen'],
            ['nama_tahapan' => 'Submit Dokumen ke Dinas Tata Ruang/Kawasan'],
            ['nama_tahapan' => 'Submit Ulang Dokumen'],
            ['nama_tahapan' => 'Upload OSS'],
            ['nama_tahapan' => 'Verifikasi Dinas Terkait'],
            ['nama_tahapan' => 'Verifikasi oleh Pemilik Bangunan'],
            ['nama_tahapan' => 'Sidang/Pemaparan Dinas'],
            ['nama_tahapan' => 'Sidang Siteplan'],
            ['nama_tahapan' => 'Tinjauan Lapangan'],
            ['nama_tahapan' => 'Revisi Siteplan Hasil Sidang'],
            ['nama_tahapan' => 'Perbaikan Dokumen Teknis'],
            ['nama_tahapan' => 'Penerbitan SKRD'],
            ['nama_tahapan' => 'Gambar'],
            ['nama_tahapan' => 'Pembuatan Gambar Siteplan'],
            ['nama_tahapan' => 'Cetak'],
            ['nama_tahapan' => 'Penerbitan Izin'],
            ['nama_tahapan' => 'Terbit Suket'],
            ['nama_tahapan' => 'Penyerahan Dokumen'],
        ]);
    }
}

