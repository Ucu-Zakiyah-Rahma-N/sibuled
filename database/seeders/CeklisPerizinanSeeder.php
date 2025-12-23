<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CeklisPerizinanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // =========================
            // 1. Sertifikat Laik Fungsi (SLF)
            // =========================
            ['perizinan_id' => 1, 'nama_dokumen' => 'KTP/KITAS/PASSPORT'],
            ['perizinan_id' => 1, 'nama_dokumen' => 'NPWP'],
            ['perizinan_id' => 1, 'nama_dokumen' => 'Akta Pendirian dan Perubahan'],
            ['perizinan_id' => 1, 'nama_dokumen' => 'NIB'],
            ['perizinan_id' => 1, 'nama_dokumen' => 'Akta Tanah'],
            ['perizinan_id' => 1, 'nama_dokumen' => 'Akta Sewa'],
            ['perizinan_id' => 1, 'nama_dokumen' => 'IMB'],
            ['perizinan_id' => 1, 'nama_dokumen' => 'Siteplan Pengesahan'],
            ['perizinan_id' => 1, 'nama_dokumen' => 'PKKPR'],
            ['perizinan_id' => 1, 'nama_dokumen' => 'KRK/IPPT/Advice Planning'],
            ['perizinan_id' => 1, 'nama_dokumen' => 'As Built Drawing Arsitektur'],
            ['perizinan_id' => 1, 'nama_dokumen' => 'As Built Drawing Struktur'],
            ['perizinan_id' => 1, 'nama_dokumen' => 'As Built Drawing MEP'],
            ['perizinan_id' => 1, 'nama_dokumen' => 'Spesifikasi Teknis'],
            ['perizinan_id' => 1, 'nama_dokumen' => 'Analisa Struktur'],
            ['perizinan_id' => 1, 'nama_dokumen' => 'Penangkal Petir dari Dinas Tenaga Kerja'],
            ['perizinan_id' => 1, 'nama_dokumen' => 'Alat Angkat Angkut dari Dinas Tenaga Kerja'],
            ['perizinan_id' => 1, 'nama_dokumen' => 'Genset dari Dinas Tenaga Kerja'],
            ['perizinan_id' => 1, 'nama_dokumen' => 'Sertifikat Ahli K3 Umum'],
            ['perizinan_id' => 1, 'nama_dokumen' => 'SLO Instalasi Listrik dari Kementrian ESDM'],
            ['perizinan_id' => 1, 'nama_dokumen' => 'AMDAL/UKL-UPL/RKL-RPL/SPPL/ANDALALIN'],
            ['perizinan_id' => 1, 'nama_dokumen' => 'Rekom Damkar'],

            // =========================
            // 2. Persetujuan Bangunan Gedung (PBG)
            // =========================
            ['perizinan_id' => 2, 'nama_dokumen' => 'KTP/KITAS/PASSPORT'],
            ['perizinan_id' => 2, 'nama_dokumen' => 'NPWP'],
            ['perizinan_id' => 2, 'nama_dokumen' => 'Akta Pendirian dan Perubahan'],
            ['perizinan_id' => 2, 'nama_dokumen' => 'NIB'],
            ['perizinan_id' => 2, 'nama_dokumen' => 'PKKPR'],
            ['perizinan_id' => 2, 'nama_dokumen' => 'KRK/IPPT/Advice Planning'],
            ['perizinan_id' => 2, 'nama_dokumen' => 'Akta Tanah'],
            ['perizinan_id' => 2, 'nama_dokumen' => 'Akta Sewa'],
            ['perizinan_id' => 2, 'nama_dokumen' => 'Siteplan Pengesahan'],
            ['perizinan_id' => 2, 'nama_dokumen' => 'As Built Drawing Arsitektur'],
            ['perizinan_id' => 2, 'nama_dokumen' => 'As Built Drawing Struktur'],
            ['perizinan_id' => 2, 'nama_dokumen' => 'As Built Drawing MEP'],
            ['perizinan_id' => 2, 'nama_dokumen' => 'AMDAL/UKL-UPL/RKL-RPL/SPPL/ANDALALIN'],

            // =========================
            // 3. As Built Drawing
            // =========================
            ['perizinan_id' => 3, 'nama_dokumen' => 'As Built Drawing'],

            // =========================
            // 4. Analisa Struktur
            // =========================
            ['perizinan_id' => 4, 'nama_dokumen' => 'Analisa Struktur'],

            // =========================
            // 5. Rekom Damkar
            // =========================
            ['perizinan_id' => 5, 'nama_dokumen' => 'Surat Permohonan'],
            ['perizinan_id' => 5, 'nama_dokumen' => 'Surat Pernyataan'],
            ['perizinan_id' => 5, 'nama_dokumen' => 'KTP/Paspor/Kitas Pemohon'],
            ['perizinan_id' => 5, 'nama_dokumen' => 'PKKPR'],
            ['perizinan_id' => 5, 'nama_dokumen' => 'KRK/IPPT/Advice Planning'],
            ['perizinan_id' => 5, 'nama_dokumen' => 'Akta Tanah'],
            ['perizinan_id' => 5, 'nama_dokumen' => 'Akta Sewa'],
            ['perizinan_id' => 5, 'nama_dokumen' => 'Siteplan Pengesahan'],
            ['perizinan_id' => 5, 'nama_dokumen' => 'As Built Drawing Arsitektur'],
            ['perizinan_id' => 5, 'nama_dokumen' => 'As Built Drawing Struktur'],
            ['perizinan_id' => 5, 'nama_dokumen' => 'As Built Drawing MEP'],
            ['perizinan_id' => 5, 'nama_dokumen' => 'AMDAL/UKL-UPL/RKL-RPL/SPPL/ANDALALIN'],

            // ✅ SLO Listrik (perizinan_id = 6)
            ['perizinan_id' => 6, 'nama_dokumen' => 'KTP/KITAS/PASPORT'],
            ['perizinan_id' => 6, 'nama_dokumen' => 'NPWP'],
            ['perizinan_id' => 6, 'nama_dokumen' => 'Akta Pendirian dan Perubahan'],
            ['perizinan_id' => 6, 'nama_dokumen' => 'NIB'],
            ['perizinan_id' => 6, 'nama_dokumen' => 'PKKPR'],
            ['perizinan_id' => 6, 'nama_dokumen' => 'KRK/IPPT/Advice Planning'],
            ['perizinan_id' => 6, 'nama_dokumen' => 'Akta Tanah'],
            ['perizinan_id' => 6, 'nama_dokumen' => 'Akta Sewa'],
            ['perizinan_id' => 6, 'nama_dokumen' => 'Siteplan Pengesahan'],
            ['perizinan_id' => 6, 'nama_dokumen' => 'As Built Drawing Arsitektur'],
            ['perizinan_id' => 6, 'nama_dokumen' => 'As Built Drawing Struktur'],
            ['perizinan_id' => 6, 'nama_dokumen' => 'As Built Drawing MEP'],
            ['perizinan_id' => 6, 'nama_dokumen' => 'AMDAL/UKL-UPL/RKL-RPL/SPPL/ANDALALIN'],

            // ✅ SLO Genset (perizinan_id = 7)
            ['perizinan_id' => 7, 'nama_dokumen' => 'NIDI'],
            ['perizinan_id' => 7, 'nama_dokumen' => 'Surat Permohonan SLO Genset'],
            ['perizinan_id' => 7, 'nama_dokumen' => 'Gambar single line diagram'],
            ['perizinan_id' => 7, 'nama_dokumen' => 'Gambar tata letak peralatan utama (genset)'],
            ['perizinan_id' => 7, 'nama_dokumen' => 'Hasil Uji Komisioning pabrikan utama'],
            ['perizinan_id' => 7, 'nama_dokumen' => 'Izin Lingkungan (AMDAL atau UKL UPL)'],
            ['perizinan_id' => 7, 'nama_dokumen' => 'Ceklist maintenance dan pemanasan Genset'],
            ['perizinan_id' => 7, 'nama_dokumen' => 'Manual Book'],
            ['perizinan_id' => 7, 'nama_dokumen' => 'SOP pengoperasian Genset'],
            ['perizinan_id' => 7, 'nama_dokumen' => 'KTP Pemohon'],
            ['perizinan_id' => 7, 'nama_dokumen' => 'NPWP'],
            ['perizinan_id' => 7, 'nama_dokumen' => 'Izin IO atau surat lapor pembangkit'],

            // ✅ RKL-RPL Rinci (perizinan_id = 8)
            ['perizinan_id' => 8, 'nama_dokumen' => 'Izin BKPM'],
            ['perizinan_id' => 8, 'nama_dokumen' => 'Surat Keterangan Domisili'],
            ['perizinan_id' => 8, 'nama_dokumen' => 'Akta Pendirian dan Perubahan'],
            ['perizinan_id' => 8, 'nama_dokumen' => 'SK Kemenhumham'],
            ['perizinan_id' => 8, 'nama_dokumen' => 'NIB'],
            ['perizinan_id' => 8, 'nama_dokumen' => 'NPWP dan PPKP'],
            ['perizinan_id' => 8, 'nama_dokumen' => 'Rekomendasi Dokumen Lingkungan sebelumnya'],
            ['perizinan_id' => 8, 'nama_dokumen' => 'Proses Produksi'],
            ['perizinan_id' => 8, 'nama_dokumen' => 'Izin mendirikan bangunan'],
            ['perizinan_id' => 8, 'nama_dokumen' => 'Sertifikat HGB/Perjanjian jual beli/Sewa'],
            ['perizinan_id' => 8, 'nama_dokumen' => 'Layout Pabrik'],
            ['perizinan_id' => 8, 'nama_dokumen' => 'Peta Lokasi'],
            ['perizinan_id' => 8, 'nama_dokumen' => 'Rekening Listrik dan Air 3 Bulan Terakhir'],
            ['perizinan_id' => 8, 'nama_dokumen' => 'Contact Person Penanggung jawab RKL-RPL Rinci'],
            ['perizinan_id' => 8, 'nama_dokumen' => 'Struktur Organisasi'],
            ['perizinan_id' => 8, 'nama_dokumen' => 'Hasil Laboratorium'],
            ['perizinan_id' => 8, 'nama_dokumen' => 'Izin TPS Limbah B3 + Rincian Teknis TPS B3 + Kompetensi Personal PLB3'],
            ['perizinan_id' => 8, 'nama_dokumen' => 'Dokumen Manifest Limbah B3 3 Bulan terakhir + Logbook + Neraca Limbah'],
            ['perizinan_id' => 8, 'nama_dokumen' => 'Izin Pengangkut Limbah B3 + MOU'],
            ['perizinan_id' => 8, 'nama_dokumen' => 'Izin Pengangkut Limbah Non B3 + MOU'],
            ['perizinan_id' => 8, 'nama_dokumen' => 'Pengelolaan Emisi + Kompetensi Personal PPU'],
            ['perizinan_id' => 8, 'nama_dokumen' => 'Pertek Air + Kompetensi Personal PPA'],
            ['perizinan_id' => 8, 'nama_dokumen' => 'MSDS dari bahan kimia yang digunakan'],
            ['perizinan_id' => 8, 'nama_dokumen' => 'Estate Regulasi KIIC'],

            // ✅ UKL-UPL (perizinan_id = 9)
            ['perizinan_id' => 9, 'nama_dokumen' => 'Surat Permohonan'],
            ['perizinan_id' => 9, 'nama_dokumen' => 'Surat Pernyataan'],
            ['perizinan_id' => 9, 'nama_dokumen' => 'Dokumen Legalitas Perusahaan (NIB, Izin Usaha, Izin Lokasi, NPWP, SKT PKP, Sertifikat Lahan, Akta Pendirian, IMB/PBG, PBB, Rek Listrik & Air 3 bulan terakhir)'],
            ['perizinan_id' => 9, 'nama_dokumen' => 'Struktur Organisasi'],
            ['perizinan_id' => 9, 'nama_dokumen' => 'Kapasitas Produksi'],
            ['perizinan_id' => 9, 'nama_dokumen' => 'List Karyawan'],
            ['perizinan_id' => 9, 'nama_dokumen' => 'Siteplan'],
            ['perizinan_id' => 9, 'nama_dokumen' => 'IMB/PBG'],
            ['perizinan_id' => 9, 'nama_dokumen' => 'Izin RT RW'],
            ['perizinan_id' => 9, 'nama_dokumen' => 'Domisili Usaha Desa dan Kawasan'],
            ['perizinan_id' => 9, 'nama_dokumen' => 'Layout Limbah, Mesin, Perusahaan, Apar'],
            ['perizinan_id' => 9, 'nama_dokumen' => 'Gambar Drainase'],
            ['perizinan_id' => 9, 'nama_dokumen' => 'Flow Proses Produksi'],
            ['perizinan_id' => 9, 'nama_dokumen' => 'List Mesin, Kendaraan, Bahan Baku'],
            ['perizinan_id' => 9, 'nama_dokumen' => 'Batas Wilayah'],
            ['perizinan_id' => 9, 'nama_dokumen' => 'Hasil Uji Lingkungan'],
            ['perizinan_id' => 9, 'nama_dokumen' => 'Rekom TPS B3/Rintek B3'],
            ['perizinan_id' => 9, 'nama_dokumen' => 'Persyaratan lain jika diminta'],

            // ✅ Rintek B3 + UKL-UPL (perizinan_id = 10)
            ['perizinan_id' => 10, 'nama_dokumen' => 'Bangunan TPL (Tempat Penyimpanan Limbah) tertutup dan sesuai ketentuan perundangan'],
            ['perizinan_id' => 10, 'nama_dokumen' => 'Bangunan TPL sudah masuk dalam IMB/PBG'],
            ['perizinan_id' => 10, 'nama_dokumen' => 'Siteplan terdapat TPS B3'],
            ['perizinan_id' => 10, 'nama_dokumen' => 'Tersedianya stiker rambu-rambu B3'],
            ['perizinan_id' => 10, 'nama_dokumen' => 'Gambar/Foto TPS B3/TPL Layout Limbah lengkap dengan eyewash'],
            ['perizinan_id' => 10, 'nama_dokumen' => 'Desain TPS B3'],
            ['perizinan_id' => 10, 'nama_dokumen' => 'Gambar Drainase'],
            ['perizinan_id' => 10, 'nama_dokumen' => 'Instruksi kerja/SOP Penyimpanan limbah'],
            ['perizinan_id' => 10, 'nama_dokumen' => 'SOP tanggap darurat limbah B3'],
            ['perizinan_id' => 10, 'nama_dokumen' => 'SOP Kecelakaan Kerja'],
            ['perizinan_id' => 10, 'nama_dokumen' => 'Neraca atau jenis limbah'],
            ['perizinan_id' => 10, 'nama_dokumen' => 'IMB/PBG'],
            ['perizinan_id' => 10, 'nama_dokumen' => 'Izin lingkungan'],
            ['perizinan_id' => 10, 'nama_dokumen' => 'NPWP'],
            ['perizinan_id' => 10, 'nama_dokumen' => 'Akta Perusahaan'],
            ['perizinan_id' => 10, 'nama_dokumen' => 'NIB'],
            ['perizinan_id' => 10, 'nama_dokumen' => 'PKKPR dari OSS'],
            ['perizinan_id' => 10, 'nama_dokumen' => 'Izin Usaha'],
            ['perizinan_id' => 10, 'nama_dokumen' => 'Izin lokasi, SKDU dari Kawasan dan SKDU dari Desa'],
            ['perizinan_id' => 10, 'nama_dokumen' => 'SPPL / RKL-RPL OSS'],
            ['perizinan_id' => 10, 'nama_dokumen' => 'Perjanjian pengelola lingkungan dengan pengelola Kawasan industri'],
            ['perizinan_id' => 10, 'nama_dokumen' => 'MOU dengan perusahaan/pengumpul/pemanfaat/pengelola'],
            ['perizinan_id' => 10, 'nama_dokumen' => 'Salinan surat pernyataan pihak ketiga tidak sedang dalam masalah hukum'],
            ['perizinan_id' => 10, 'nama_dokumen' => 'Salinan asuransi pencemaran lingkungan pihak ketiga'],
            ['perizinan_id' => 10, 'nama_dokumen' => 'Salinan pengangkut tidak dalam masalah lingkungan'],
            ['perizinan_id' => 10, 'nama_dokumen' => 'Company Profile Pihak ketiga (Legalitas, Angkutan terdaftar dishub, KLHK)'],
            ['perizinan_id' => 10, 'nama_dokumen' => 'Logbook (3 bulan terakhir)'],
            ['perizinan_id' => 10, 'nama_dokumen' => 'Manifest Limbah 3 bulan terakhir dan surat pemusnahannya'],
            ['perizinan_id' => 10, 'nama_dokumen' => 'Sertifikat Operator B3 (OPL B3/PLB3)'],
            ['perizinan_id' => 10, 'nama_dokumen' => 'Hasil Lab Monitoring lingkungan terbaru'],
            ['perizinan_id' => 10, 'nama_dokumen' => 'Pemakaian listrik dan air 3 bulan terakhir'],
            ['perizinan_id' => 10, 'nama_dokumen' => 'Tata letak Apar/Hydrant/Proteksi kebakaran'],
            ['perizinan_id' => 10, 'nama_dokumen' => 'Peta lokasi (gambar batas kiri kanan belakang depan, bukan foto Google)'],
            ['perizinan_id' => 10, 'nama_dokumen' => 'Surat permohonan (dari konsultan)'],

            // ✅ AMDAL (ID 11)
            ['perizinan_id' => 11, 'nama_dokumen' => 'Surat Pemohon Uji Kelayakan Lingkungan Hidup (Ditujukan ke Menteri Lingkungan Hidup dan Kehutanan)'],
            ['perizinan_id' => 11, 'nama_dokumen' => 'Surat Arahan Penyusunan Lingkungan/Screenshot laman OSS RBA yang menampilkan kegiatan dan jenis dokumen lingkungannya'],
            ['perizinan_id' => 11, 'nama_dokumen' => 'NIB OSS RBA'],
            ['perizinan_id' => 11, 'nama_dokumen' => 'SPPL'],
            ['perizinan_id' => 11, 'nama_dokumen' => 'SK eksisting yang diajukan perubahannya jika perubahan'],
            ['perizinan_id' => 11, 'nama_dokumen' => 'Dokumen Lingkungan Eksisting yang dimiliki'],
            ['perizinan_id' => 11, 'nama_dokumen' => 'Izin Usaha OSS dan Izin OSS lainnya'],
            ['perizinan_id' => 11, 'nama_dokumen' => 'Surat pernyataan bahwa kegiatan masih dalam tahap perencanaan'],
            ['perizinan_id' => 11, 'nama_dokumen' => 'Surat pernyataan kebenaran data'],
            ['perizinan_id' => 11, 'nama_dokumen' => 'Surat pernyataan kesediaan menyesuaikan proses penilaian/pemeriksaan dokumen lingkungan'],
            ['perizinan_id' => 11, 'nama_dokumen' => 'Identitas Pemohon'],
            ['perizinan_id' => 11, 'nama_dokumen' => 'NPWP Pemohon'],
            ['perizinan_id' => 11, 'nama_dokumen' => 'Dokumen Legalitas Perusahaan (NIB, Izin Usaha, Izin Lokasi, NPWP, Sertifikat Lahan/AJB, Akta Pendirian, IMB/PBG, PBB, Siteplan, dll)'],
            ['perizinan_id' => 11, 'nama_dokumen' => 'Amdal Sebelumnya (jika perubahan)'],
            ['perizinan_id' => 11, 'nama_dokumen' => 'Struktur Organisasi'],
            ['perizinan_id' => 11, 'nama_dokumen' => 'Kapasitas Produksi'],
            ['perizinan_id' => 11, 'nama_dokumen' => 'List Karyawan'],
            ['perizinan_id' => 11, 'nama_dokumen' => 'Siteplan dan IMB/PBG tervalidasi'],
            ['perizinan_id' => 11, 'nama_dokumen' => 'Domisili Usaha desa dan kawasan'],
            ['perizinan_id' => 11, 'nama_dokumen' => 'Layout Pembuangan Limbah'],
            ['perizinan_id' => 11, 'nama_dokumen' => 'Layout Mesin'],
            ['perizinan_id' => 11, 'nama_dokumen' => 'Layout Perusahaan'],
            ['perizinan_id' => 11, 'nama_dokumen' => 'Layout APAR'],
            ['perizinan_id' => 11, 'nama_dokumen' => 'Gambar Drainase'],
            ['perizinan_id' => 11, 'nama_dokumen' => 'Flow Proses Produksi'],
            ['perizinan_id' => 11, 'nama_dokumen' => 'List Mesin dan Peralatan'],
            ['perizinan_id' => 11, 'nama_dokumen' => 'List Kendaraan'],
            ['perizinan_id' => 11, 'nama_dokumen' => 'List Bahan Baku dan Penolong'],
            ['perizinan_id' => 11, 'nama_dokumen' => 'Daftar Tanaman di Sekitar Area'],
            ['perizinan_id' => 11, 'nama_dokumen' => 'List Penggunaan Bahan Bakar'],
            ['perizinan_id' => 11, 'nama_dokumen' => 'Batas Wilayah (Timur, Barat, Selatan, Utara)'],
            ['perizinan_id' => 11, 'nama_dokumen' => 'Layout TPL Limbah B3'],
            ['perizinan_id' => 11, 'nama_dokumen' => 'Hasil Uji Lingkungan'],
            ['perizinan_id' => 11, 'nama_dokumen' => 'Izin Lingkungan lain seperti Rintek B3, Izin Sumur/Pertek'],
            ['perizinan_id' => 11, 'nama_dokumen' => 'Kop surat dan stempel (format Word)'],
            ['perizinan_id' => 11, 'nama_dokumen' => 'Persyaratan lainnya jika diminta'],

            // 12
            ['perizinan_id' => 12, 'nama_dokumen' => 'Laporan Per Semester'],
            // ✅ Pertek Emisi (ID 13)
            ['perizinan_id' => 13, 'nama_dokumen' => 'Surat Permohonan'],
            ['perizinan_id' => 13, 'nama_dokumen' => 'Surat Pernyataan'],
            ['perizinan_id' => 13, 'nama_dokumen' => 'Identitas Pemohon'],
            ['perizinan_id' => 13, 'nama_dokumen' => 'NPWP Pemohon'],
            ['perizinan_id' => 13, 'nama_dokumen' => 'Dokumen Legalitas Perusahaan (NIB, Izin Usaha, Izin Lokasi, NPWP, Sertifikat Lahan, Akta, IMB/PBG, PBB, Rek Listrik & Air)'],
            ['perizinan_id' => 13, 'nama_dokumen' => 'SPPL, UKL-UPL'],
            ['perizinan_id' => 13, 'nama_dokumen' => 'Identifikasi sumber, kuantitas, dan karakteristik limbah'],
            ['perizinan_id' => 13, 'nama_dokumen' => 'Identifikasi penerima limbah'],
            ['perizinan_id' => 13, 'nama_dokumen' => 'Tata letak/Layout'],
            ['perizinan_id' => 13, 'nama_dokumen' => 'Desain Instalasi'],
            ['perizinan_id' => 13, 'nama_dokumen' => 'Data sirkulasi udara/air'],
            ['perizinan_id' => 13, 'nama_dokumen' => 'Informasi sistem pengolahan limbah/emisi'],
            ['perizinan_id' => 13, 'nama_dokumen' => 'Prosedur tanggap darurat instalasi pengolahan limbah/emisi'],
            ['perizinan_id' => 13, 'nama_dokumen' => 'Hasil Uji Kualitas Udara'],
            ['perizinan_id' => 13, 'nama_dokumen' => 'Area sensitif di sekitar pengolahan limbah/emisi'],
            ['perizinan_id' => 13, 'nama_dokumen' => 'Prediksi sebaran limbah'],
            ['perizinan_id' => 13, 'nama_dokumen' => 'Sertifikasi PPPU/POIPU'],
            ['perizinan_id' => 13, 'nama_dokumen' => 'Persyaratan lainnya jika diminta'],


            // 14
            ['perizinan_id' => 14, 'nama_dokumen' => 'SLO Emisi'],

            // 15
            ['perizinan_id' => 15, 'nama_dokumen' => 'Pertek Air Limbah'],

            // 16
            ['perizinan_id' => 16, 'nama_dokumen' => 'SLO Air'],
            
            // 17
            ['perizinan_id' => 17, 'nama_dokumen' => 'Uji Laboratorium'],

             // ✅ ANDALALIN (ID 18)
            ['perizinan_id' => 18, 'nama_dokumen' => 'KTP/KITAS/Identitas Pemilik Bangunan Gedung'],
            ['perizinan_id' => 18, 'nama_dokumen' => 'NPWP Pemilik'],
            ['perizinan_id' => 18, 'nama_dokumen' => 'NPWP Perusahaan'],
            ['perizinan_id' => 18, 'nama_dokumen' => 'NIB'],
            ['perizinan_id' => 18, 'nama_dokumen' => 'Akta Perusahaan'],
            ['perizinan_id' => 18, 'nama_dokumen' => 'PKKPR dari OSS'],
            ['perizinan_id' => 18, 'nama_dokumen' => 'Izin Usaha'],
            ['perizinan_id' => 18, 'nama_dokumen' => 'Izin Lingkungan SPPL/RKL-RPL OSS'],
            ['perizinan_id' => 18, 'nama_dokumen' => 'SKDU (Domisili usaha) dari desa'],
            ['perizinan_id' => 18, 'nama_dokumen' => 'Layout Pabrik'],
            ['perizinan_id' => 18, 'nama_dokumen' => 'Satuan Lahan Parkir'],
            ['perizinan_id' => 18, 'nama_dokumen' => 'IMB/PBG'],
            ['perizinan_id' => 18, 'nama_dokumen' => 'Siteplan Pengesahan'],
            ['perizinan_id' => 18, 'nama_dokumen' => 'Sertifikat Kepemilikan'],
            ['perizinan_id' => 18, 'nama_dokumen' => 'Data lainnya jika dibutuhkan'],

            // ✅ Siteplan (ID 19)
            ['perizinan_id' => 19, 'nama_dokumen' => 'Surat Permohonan'],
            ['perizinan_id' => 19, 'nama_dokumen' => 'Fotokopi KTP Pemohon'],
            ['perizinan_id' => 19, 'nama_dokumen' => 'Surat Kuasa bermaterai (jika dikuasakan)'],
            ['perizinan_id' => 19, 'nama_dokumen' => 'Fotokopi NIB'],
            ['perizinan_id' => 19, 'nama_dokumen' => 'Fotokopi Akta Pendirian/Dokumen Perusahaan'],
            ['perizinan_id' => 19, 'nama_dokumen' => 'Fotokopi KRK'],
            ['perizinan_id' => 19, 'nama_dokumen' => 'Fotokopi Pertimbangan Teknis dari BPN'],
            ['perizinan_id' => 19, 'nama_dokumen' => 'Fotokopi Sertifikat Kepemilikan Tanah (HGB/SHM)'],
            ['perizinan_id' => 19, 'nama_dokumen' => 'PBB Tahun Berjalan'],
            ['perizinan_id' => 19, 'nama_dokumen' => 'Rekomendasi dan Dokumen AMDAL/UKL/UPL'],
            ['perizinan_id' => 19, 'nama_dokumen' => 'Rekomendasi ANDALALIN'],
            ['perizinan_id' => 19, 'nama_dokumen' => 'Rekomendasi kajian hidrologi dan peil banjir'],
            ['perizinan_id' => 19, 'nama_dokumen' => 'Pengesahan Siteplan lama'],
            ['perizinan_id' => 19, 'nama_dokumen' => 'Gambar Rencana Tapak (AutoCAD) lengkap koordinat'],
            ['perizinan_id' => 19, 'nama_dokumen' => 'Peta kontur tanah eksisting'],

            // ✅ KRK (ID 20)
            ['perizinan_id' => 20, 'nama_dokumen' => 'KTP/KITAS/PASPORT Pemilik Bangunan'],
            ['perizinan_id' => 20, 'nama_dokumen' => 'NPWP'],
            ['perizinan_id' => 20, 'nama_dokumen' => 'Akta Perusahaan'],
            ['perizinan_id' => 20, 'nama_dokumen' => 'SPPL'],
            ['perizinan_id' => 20, 'nama_dokumen' => 'NIB'],
            ['perizinan_id' => 20, 'nama_dokumen' => 'Titik Koordinat'],
            ['perizinan_id' => 20, 'nama_dokumen' => 'Akta Tanah'],
            ['perizinan_id' => 20, 'nama_dokumen' => 'Siteplan atau Rencana Layout Bangunan Gedung'],

            // 21
            ['perizinan_id' => 21, 'nama_dokumen' => 'PKKPR'],

            // 22 
            [
                'perizinan_id' => 22,
                'nama_dokumen' => 'Memiliki akun SIINas dan telah melakukan input data perusahaan serta laporan pembangunan pada SIINas yang dibuktikan dengan download hasil laporan pembangunan dan laporan produksi (bukti telah lapor, berbentuk pdf)',
            ],
            [
                'perizinan_id' => 22,
                'nama_dokumen' => 'Laporan Keuangan yang terdiri nilai tanah, bangunan, gedung, mesin dan peralatan, modal kerja 3 bulan dan investasi lainnya dalam bentuk Laporan Keuangan dari Akuntan Independen atau laporan keuangan internal (pdf)',
            ],
            [
                'perizinan_id' => 22,
                'nama_dokumen' => 'Data spesifikasi mesin utama dan pendukung sesuai dengan jenis KBLI yang disertakan asal negara (pdf/excel)',
            ],
            [
                'perizinan_id' => 22,
                'nama_dokumen' => 'Rincian perhitungan kapasitas terpasang produk berupa perhitungan kapasitas maksimum mesin. Pastikan terdapat informasi kapasitas per jam, per hari, per bulan dan per tahun beserta asumsi perhitungan yang digunakan (pdf)',
            ],
            [
                'perizinan_id' => 22,
                'nama_dokumen' => 'Data real produksi dalam 1 tahun maksimal yang pernah dicapai (jika sudah berproduksi)',
            ],
            [
                'perizinan_id' => 22,
                'nama_dokumen' => 'Rincian bahan baku dan bahan penolong yang digunakan disertakan dengan asal negara, sesuai dengan jenis KBLI yang diajukan (pdf/excel)',
            ],
            [
                'perizinan_id' => 22,
                'nama_dokumen' => 'Rincian jumlah tenaga kerja untuk KBLI yang diajukan (berdasarkan jenis kelamin/pekerja tetap atau kontrak/buruh/harian dan WNA atau WNI) dalam bentuk pdf',
            ],
            [
                'perizinan_id' => 22,
                'nama_dokumen' => 'Surat Keterangan telah membangun sumur imbuhan/resapan',
            ],
            [
                'perizinan_id' => 22,
                'nama_dokumen' => 'Persetujuan Lingkungan (PKPLH - UKL/UPL, RKL/RPL, AMDAL) berupa surat rekomendasi dan halaman di dokumen lingkungan yang terdapat kapasitas terpasang (pdf)',
            ],
            [
                'perizinan_id' => 22,
                'nama_dokumen' => 'PKKPR dari OSS RBA (pdf)',
            ],
            [
                'perizinan_id' => 22,
                'nama_dokumen' => 'Akta Perusahaan (pdf)',
            ],
            [
                'perizinan_id' => 22,
                'nama_dokumen' => 'IMB/PBG Perusahaan atau Perjanjian Sewa (pdf)',
            ],
            [
                'perizinan_id' => 22,
                'nama_dokumen' => 'NIB dari OSS RBA (pdf)',
            ],
            [
                'perizinan_id' => 22,
                'nama_dokumen' => 'SLF (pdf)',
            ],
            [
                'perizinan_id' => 22,
                'nama_dokumen' => 'NIB dan Izin/Sertifikat Standar serta IUI yang dimiliki sebelum berlakunya UUCK (jika ada)',
            ],
            [
                'perizinan_id' => 22,
                'nama_dokumen' => 'Surat Pernyataan Berada di luar kawasan Industri dari SIINas (bila berada di luar kawasan Industri)/ Surat pernyataan berada di Kawasan Industri dari Pengelola Kawasan Industri (bila berada di kawasan Industri)',
            ],
            [
                'perizinan_id' => 22,
                'nama_dokumen' => 'Panduan dapat di download pada link terkait',
            ],
            [
                'perizinan_id' => 22,
                'nama_dokumen' => 'Tampilan Nomor Kegiatan Usaha, Nilai investasi, Data Tenaga Kerja, Kapasitas Terpasang dan Jenis Produk pada OSS RBA yang diajukan verifikasinya',
            ],

            // 12
            ['perizinan_id' => 23, 'nama_dokumen' => 'Riksa Uji K3 Alat'],
            // 12
            ['perizinan_id' => 24, 'nama_dokumen' => 'Sertifikasi AK3U'],
            // 12
            ['perizinan_id' => 25, 'nama_dokumen' => 'IPTB/SKK'],
            // 12
            ['perizinan_id' => 26, 'nama_dokumen' => 'DED'],
            // 12
            ['perizinan_id' => 27, 'nama_dokumen' => 'Pembangunan'],
            
            //28 peil banjir
            [
                'perizinan_id' => 28,
                'nama_dokumen' => 'Surat permohonan',
            ],
            [
                'perizinan_id' => 28,
                'nama_dokumen' => 'Fotokopi Kartu Tanda Penduduk (KTP) pemohon',
            ],
            [
                'perizinan_id' => 28,
                'nama_dokumen' => 'Surat Kuasa Asli Bermaterai apabila dikuasakan',
            ],
            [
                'perizinan_id' => 28,
                'nama_dokumen' => 'Fotokopi Nomor Induk Berusaha (NIB)',
            ],
            [
                'perizinan_id' => 28,
                'nama_dokumen' => 'Fotokopi Akta Pendirian/Dokumen Kepemilikan Perusahaan',
            ],
            [
                'perizinan_id' => 28,
                'nama_dokumen' => 'Fotokopi Pertimbangan Teknis dari BPN',
            ],
            [
                'perizinan_id' => 28,
                'nama_dokumen' => 'Gambar Rencana Tapak (Siteplan) yang sudah disesuaikan dengan Bidang Tanah yang disahkan oleh BPN dalam format AutoCAD (.dwg) dan dilengkapi dengan koordinatnya',
            ],
            [
                'perizinan_id' => 28,
                'nama_dokumen' => 'Peta Kontur Tanah Eksisting pada lokasi yang dimohonkan (format CAD/SHP)',
            ],
            [
                'perizinan_id' => 28,
                'nama_dokumen' => 'Rekomendasi kajian hidrologi jika luas tanah lebih dari 5 hektar',
            ],

            // 29
            ['perizinan_id' => 29, 'nama_dokumen' => 'Kasosek'],
            
            // 30
            ['perizinan_id' => 30, 'nama_dokumen' => 'Rekom Indag'],

            // 31
            ['perizinan_id' => 31, 'nama_dokumen' => 'SHGB'],

            // 32
            ['perizinan_id' => 32, 'nama_dokumen' => 'Assessment Bangunan'],

            // 33
            ['perizinan_id' => 33, 'nama_dokumen' => 'TDG'],

            // // ✅ BOILER
            // [
            //     'perizinan_id' => null, // belum ada di list 33 perizinan
            //     'nama_dokumen' => json_encode([
            //         "Gambar rencana/Gambar teknik yang sudah ditandatangani Kemnaker (baru & bekas)",
            //         "Pengujian hydrotest (baru & bekas)",
            //         "Pengujian Steam test (baru & bekas)",
            //         "Perhitungan kekuatan material",
            //         "Sertifikat material",
            //         "Gambar konstruksi dan pengelasan"
            //     ]),
            // ],

            
        ];
          DB::table('ceklis_perizinan')->insert($data);
    }
}
