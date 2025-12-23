<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KawasanIndustri;

class KawasanIndustriSeeder extends Seeder
{
    public function run()
    {
        $kawasan = [

        // 🌍 ACEH
        ['nama_kawasan' => 'Kawasan Industri Aceh - Ladong', 'kabupaten_kode' => '1108'], // Kab. Aceh Besar

        // 🌴 SUMATERA UTARA
        ['nama_kawasan' => 'Kawasan Industri Kuala Tanjung', 'kabupaten_kode' => '1219'], // Kab. Batubara
        ['nama_kawasan' => 'Kawasan Industri Sei Mangkei', 'kabupaten_kode' => '1209'], // Kab. Simalungun
        ['nama_kawasan' => 'Kawasan Industri Medan I (KIM I)', 'kabupaten_kode' => '1275'], // Kota Medan
        ['nama_kawasan' => 'Kawasan Industri Medan II (KIM II)', 'kabupaten_kode' => '1275'], // Kota Medan

        // 🌾 RIAU
        ['nama_kawasan' => 'Kawasan Industri Tanjung Buton', 'kabupaten_kode' => '1405'], // Kab. Siak
        ['nama_kawasan' => 'Kawasan Industri Dumai', 'kabupaten_kode' => '1473'], // Kota Dumai
        ['nama_kawasan' => 'Kawasan Industri Tenayan Raya', 'kabupaten_kode' => '1471'], // Kota Pekanbaru
        ['nama_kawasan' => 'Kawasan Industri Dumai Baru', 'kabupaten_kode' => '1471'],

        // 🌴 KEPULAUAN RIAU
        ['nama_kawasan' => 'Bintan Inti Industrial Estate', 'kabupaten_kode' => '2102'], // Kab. Bintan
        ['nama_kawasan' => 'Kawasan Industri Bintan', 'kabupaten_kode' => '2102'],
        ['nama_kawasan' => 'Batamindo Industrial Park', 'kabupaten_kode' => '2171'], // Kota Batam
        ['nama_kawasan' => 'Bintang Industrial Park', 'kabupaten_kode' => '2171'],
        ['nama_kawasan' => 'Cammo Industrial Park', 'kabupaten_kode' => '2171'],

        // 🌿 LAMPUNG
        ['nama_kawasan' => 'Kawasan Industri Way Pisang', 'kabupaten_kode' => '1803'], // Kab. Lampung Selatan
        ['nama_kawasan' => 'Kawasan Industri Lampung', 'kabupaten_kode' => '1871'], // Kota Bandar Lampung
        ['nama_kawasan' => 'Kawasan Industri Panjang', 'kabupaten_kode' => '1871'],

        // 🏭 SUMATERA SELATAN
        ['nama_kawasan' => 'Kawasan Industri Tanjung Api-api', 'kabupaten_kode' => '1607'], // Kab. Banyuasin

        // 🏙️ BANTEN
        ['nama_kawasan' => 'Kawasan Industri Modern Cikande', 'kabupaten_kode' => '3604'], // Kab. Serang
        ['nama_kawasan' => 'Kawasan Industri Krakatau Cilegon', 'kabupaten_kode' => '3672'], // Kota Cilegon
        ['nama_kawasan' => 'Kawasan Industri KIEC Cilegon', 'kabupaten_kode' => '3672'],
        ['nama_kawasan' => 'Krakatau Industrial Estate Cilegon', 'kabupaten_kode' => '3672'],
        ['nama_kawasan' => 'Kawasan Industri Pasar Kemis', 'kabupaten_kode' => '3671'], // Kab. Tangerang
        ['nama_kawasan' => 'Kawasan Industri Cikupa Mas', 'kabupaten_kode' => '3671'],
        ['nama_kawasan' => 'Kawasan Industri Balaraja', 'kabupaten_kode' => '3671'],
        ['nama_kawasan' => 'Kawasan Industri Millenium', 'kabupaten_kode' => '3671'],
        ['nama_kawasan' => 'Millenium Industrial Estate', 'kabupaten_kode' => '3671'],
        ['nama_kawasan' => 'Kawasan Industri Modernland', 'kabupaten_kode' => '3671'],
        ['nama_kawasan' => 'Kawasan Industri Manis (Modernland)', 'kabupaten_kode' => '3671'],
        ['nama_kawasan' => 'Kawasan Industri Taman Tekno BSD', 'kabupaten_kode' => '3674'], // Kota Tangerang Selatan

        // 🧱 JAWA BARAT
        ['nama_kawasan' => 'Kawasan Industri Sentul', 'kabupaten_kode' => '3201'], // Kab. Bogor
        ['nama_kawasan' => 'Kawasan Industri Sentul Bogor', 'kabupaten_kode' => '3201'],
        ['nama_kawasan' => 'Kawasan Industri Majalengka Aerocity', 'kabupaten_kode' => '3210'], // Kab. Majalengka
        ['nama_kawasan' => 'Kawasan Industri Subang Smartpolitan', 'kabupaten_kode' => '3213'], // Kab. Subang
        ['nama_kawasan' => 'Kawasan Industri Karawang International Industrial City (KIIC)', 'kabupaten_kode' => '3215'], // Kab. Karawang
        ['nama_kawasan' => 'Kawasan Industri Surya Cipta', 'kabupaten_kode' => '3215'],
        ['nama_kawasan' => 'Kawasan Industri Kujang Cikampek', 'kabupaten_kode' => '3215'],
        ['nama_kawasan' => 'Kawasan Industri Indotaisei', 'kabupaten_kode' => '3215'],
        ['nama_kawasan' => 'Kawasan Industri Bukit Indah City', 'kabupaten_kode' => '3215'],
        ['nama_kawasan' => 'Kawasan Industri Suryacipta Karawang', 'kabupaten_kode' => '3215'],
        ['nama_kawasan' => 'Kawasan Industri Karawang Timur', 'kabupaten_kode' => '3215'],
        ['nama_kawasan' => 'Kawasan Industri Mitrakarawang', 'kabupaten_kode' => '3215'],
        ['nama_kawasan' => 'Kawasan Industri Jababeka', 'kabupaten_kode' => '3216'], // Kab. Bekasi
        ['nama_kawasan' => 'MM2100 Industrial Town', 'kabupaten_kode' => '3216'],
        ['nama_kawasan' => 'Greenland International Industrial Center (GIIC)', 'kabupaten_kode' => '3216'],
        ['nama_kawasan' => 'Kawasan Industri Delta Silicon', 'kabupaten_kode' => '3216'],
        ['nama_kawasan' => 'Kawasan Industri Lippo Cikarang', 'kabupaten_kode' => '3216'],
        ['nama_kawasan' => 'Kawasan Industri Hyundai', 'kabupaten_kode' => '3216'],
        ['nama_kawasan' => 'Kawasan Industri Deltamas', 'kabupaten_kode' => '3216'],

        // 🏗️ JAWA TENGAH
        ['nama_kawasan' => 'Kawasan Industri Cilacap', 'kabupaten_kode' => '3301'], // Kab. Cilacap
        ['nama_kawasan' => 'Kawasan Industri Terpadu Batang', 'kabupaten_kode' => '3325'], // Kab. Batang
        ['nama_kawasan' => 'Kawasan Industri Kendal', 'kabupaten_kode' => '3324'], // Kab. Kendal
        ['nama_kawasan' => 'Kawasan Industri Candi', 'kabupaten_kode' => '3322'], // Kota Semarang
        ['nama_kawasan' => 'Kawasan Industri Wijayakusuma', 'kabupaten_kode' => '3322'],
        ['nama_kawasan' => 'Kawasan Industri Bukit Semarang Baru', 'kabupaten_kode' => '3322'],
        ['nama_kawasan' => 'Kawasan Industri Terboyo', 'kabupaten_kode' => '3322'],

        // 🎨 DI YOGYAKARTA
        ['nama_kawasan' => 'Kawasan Industri Piyungan Creative Economy Park', 'kabupaten_kode' => '3402'], // Kab. Bantul

        // ⚙️ JAWA TIMUR
        ['nama_kawasan' => 'Kawasan Industri Safe N Lock', 'kabupaten_kode' => '3515'], // Kab. Sidoarjo
        ['nama_kawasan' => 'Kawasan Industri Ngoro', 'kabupaten_kode' => '3516'], // Kab. Mojokerto
        ['nama_kawasan' => 'Kawasan Industri Pasuruan Industrial Estate Rembang (PIER)', 'kabupaten_kode' => '3514'], // Kab. Pasuruan
        ['nama_kawasan' => 'Java Integrated Industrial and Port Estate (JIIPE)', 'kabupaten_kode' => '3525'], // Kab. Gresik
        ['nama_kawasan' => 'Kawasan Industri Surabaya Industrial Estate Rungkut (SIER)', 'kabupaten_kode' => '3578'], // Kota Surabaya

        // 🏙️ DKI JAKARTA
        ['nama_kawasan' => 'Kawasan Industri Pulogadung (JIEP)', 'kabupaten_kode' => '3172'], // Jakarta Timur
        ['nama_kawasan' => 'Kawasan Industri Halim', 'kabupaten_kode' => '3172'],
        ['nama_kawasan' => 'Kawasan Berikat Nusantara (KBN)', 'kabupaten_kode' => '3175'], // Jakarta Utara
        ['nama_kawasan' => 'Kawasan Industri Marunda Center', 'kabupaten_kode' => '3175'],
        ['nama_kawasan' => 'Kawasan Industri Tanjung Priok', 'kabupaten_kode' => '3175'],

        // 🌿 KALIMANTAN
        ['nama_kawasan' => 'Kawasan Industri Ketapang', 'kabupaten_kode' => '6106'], // Kab. Ketapang
        ['nama_kawasan' => 'Kawasan Industri Maloy Batuta Trans Kalimantan (MBTK)', 'kabupaten_kode' => '6404'], // Kab. Kutai Timur
        ['nama_kawasan' => 'Kawasan Industri Buluminung', 'kabupaten_kode' => '6409'], // Kab. Penajam Paser Utara
        ['nama_kawasan' => 'Kawasan Industri Kariangau', 'kabupaten_kode' => '6471'], // Kota Balikpapan
        ['nama_kawasan' => 'Kawasan Industri Samarinda', 'kabupaten_kode' => '6472'], // Kota Samarinda
        ['nama_kawasan' => 'Kawasan Industri Pontianak', 'kabupaten_kode' => '6171'], // Kota Pontianak

        // 🌊 SULAWESI
        ['nama_kawasan' => 'Kawasan Industri Morowali', 'kabupaten_kode' => '7203'], // Kab. Morowali
        ['nama_kawasan' => 'Kawasan Industri Morowali Utara', 'kabupaten_kode' => '7212'], // Kab. Morowali Utara
        ['nama_kawasan' => 'Kawasan Industri Palu', 'kabupaten_kode' => '7271'], // Kota Palu
        ['nama_kawasan' => 'Kawasan Industri Bantaeng', 'kabupaten_kode' => '7303'], // Kab. Bantaeng
        ['nama_kawasan' => 'Kawasan Industri Luwu Timur', 'kabupaten_kode' => '7322'], // Kab. Luwu Timur
        ['nama_kawasan' => 'Kawasan Industri Konawe', 'kabupaten_kode' => '7403'], // Kab. Konawe
        ['nama_kawasan' => 'Kawasan Industri Motui', 'kabupaten_kode' => '7410'], // Kab. Konawe Utara
        ['nama_kawasan' => 'Kawasan Industri Makassar', 'kabupaten_kode' => '7371'], // Kota Makassar
        ['nama_kawasan' => 'Kawasan Industri Kendari', 'kabupaten_kode' => '7471'], // Kota Kendari
        ['nama_kawasan' => 'Kawasan Industri Mamuju', 'kabupaten_kode' => '7604'], // Kab. Mamuju
        ['nama_kawasan' => 'Kawasan Industri Bitung', 'kabupaten_kode' => '7172'], // Kota Bitung

        // 🏝️ MALUKU & PAPUA
        ['nama_kawasan' => 'Kawasan Industri Halmahera', 'kabupaten_kode' => '8202'], // Kab. Halmahera Tengah
        ['nama_kawasan' => 'Kawasan Industri Pulau Obi', 'kabupaten_kode' => '8204'], // Kab. Halmahera Selatan
        // ['nama_kawasan' => 'Kawasan Industri Teluk Weda', 'kabupaten_kode' => '7574'], // Kab. Halmahera Utara
        ['nama_kawasan' => 'Kawasan Industri Ambon', 'kabupaten_kode' => '8171'], // Kota Ambon
        ['nama_kawasan' => 'Kawasan Industri Tual', 'kabupaten_kode' => '8172'], // Kota Tual
        ['nama_kawasan' => 'Kawasan Industri Teluk Bintuni', 'kabupaten_kode' => '9104'], // Kab. Teluk Bintuni
        ['nama_kawasan' => 'Kawasan Industri Sorong', 'kabupaten_kode' => '9171'], // Kab. Sorong
     ];

        foreach ($kawasan as $item) {
            KawasanIndustri::updateOrCreate(
                ['nama_kawasan' => $item['nama_kawasan']], // unik
                ['kabupaten_kode' => $item['kabupaten_kode']]
            );
        }
    }
}

