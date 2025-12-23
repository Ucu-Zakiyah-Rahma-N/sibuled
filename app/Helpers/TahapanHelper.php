<?php

if (!function_exists('tahapan_color')) {

    function tahapan_color(string $namaTahapan): string
    {
        $map = [
            'Collect Dokumen' => '#4e79a7',
            'Screening Dokumen' => '#59a14f',
            'Surat Permohonan' => '#f28e2c',
            'Surat Komitmen' => '#e15759',
            'Peta Polygon' => '#76b7b2',

            'Survey' => '#edc948',
            'Tinjauan Lokasi' => '#b07aa1',
            'Pengkajian Teknis' => '#ff9da7',

            'Pembuatan Kajian Laporan Semester' => '#9c755f',
            'Pembuatan Kajian Assessment dan RAB' => '#bab0ab',
            'Penyusunan Laporan Hasil Pemeriksaan' => '#4e79a7',

            'Pengesahan Siteplan' => '#59a14f',
            'Konsultasi Dinas' => '#f28e2c',
            'Konsultasi Dinas 1' => '#e15759',
            'Konsultasi Dinas 2' => '#76b7b2',

            'Submit SIMBG' => '#edc948',
            'Submit Dokumen' => '#b07aa1',
            'Submit Dokumen ke Dinas Tata Ruang/Kawasan' => '#ff9da7',
            'Submit Ulang Dokumen' => '#9c755f',

            'Upload OSS' => '#bab0ab',
            'Verifikasi Dinas Terkait' => '#4e79a7',
            'Verifikasi oleh Pemilik Bangunan' => '#59a14f',

            'Sidang/Pemaparan Dinas' => '#f28e2c',
            'Sidang Siteplan' => '#e15759',
            'Tinjauan Lapangan' => '#76b7b2',

            'Revisi Siteplan Hasil Sidang' => '#edc948',
            'Perbaikan Dokumen Teknis' => '#b07aa1',

            'Penerbitan SKRD' => '#ff9da7',
            'Gambar' => '#9c755f',
            'Pembuatan Gambar Siteplan' => '#bab0ab',

            'Cetak' => '#4e79a7',
            'Penerbitan Izin' => '#59a14f',
            'Terbit Suket' => '#f28e2c',
            'Penyerahan Dokumen' => '#e15759',
        ];

        return $map[$namaTahapan] ?? '#95a5a6'; // default abu-abu
    }
}
