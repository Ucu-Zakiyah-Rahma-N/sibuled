<?php

namespace Database\Seeders;

use App\Models\Bagian;
use App\Models\Profile;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

    Bagian::insert([
        [
            'nama_bagian' => 'Kabag',
            'nama_organisasi'=> 'Perekonomian',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
              [
            'nama_bagian' => 'Sekda',
            'nama_organisasi'=> 'OPD',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'nama_bagian' => 'Asda',
            'nama_organisasi'=> 'OPD',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'nama_bagian' => 'BPKAD',
            'nama_organisasi'=> 'OPD',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'nama_bagian' => 'LKM',
            'nama_organisasi'=> 'BUMD',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'nama_bagian' => 'BPR',
            'nama_organisasi'=> 'BUMD',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'nama_bagian' => 'Perumdam',
            'nama_organisasi'=> 'BUMD',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'nama_bagian' => 'Petrogas',
            'nama_organisasi'=> 'BUMD',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
    ]);

    User::insert([
        [
            'username' => 'kabag',
            'email' => 'kabag@example.id',
            'password' => bcrypt('karawang'),
            'bagian_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
                [
            'username' => 'sekda',
            'email' => 'sekda@example.id',
            'password' => bcrypt('karawang'),
            'bagian_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'username' => 'asda',
            'email' => 'asda@example.id',
            'password' => bcrypt('karawang'),
            'bagian_id' => 3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'username' => 'bpkad',
            'email' => 'bpkad@example.id',
            'password' => bcrypt('karawang'),
            'bagian_id' => 4,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'username' => 'lkm',
            'email' => 'lkm@example.id',
            'password' => bcrypt('karawang'),
            'bagian_id' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'username' => 'bpr',
            'email' => 'bpr@example.id',
            'password' => bcrypt('karawang'),
            'bagian_id' => 6,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'username' => 'perumdam',
            'email' => 'perumdam@example.id',
            'password' => bcrypt('karawang'),
            'bagian_id' => 7,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'username' => 'petrogas',
            'email' => 'petrogas@example.id',
            'password' => bcrypt('karawang'),
            'bagian_id' => 8,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
    ]);

    Profile::insert([
        [
            'user_id' => 1,
            'nama' => 'Hj. Yayat Rohayati, MM.',
            'golongan' => 'Pembina Utama Muda',
            'nip'=>'196711081993032003',
            'ttd' => null,
        ],
        [
            'user_id' => 2,
            'nama' => 'H. Asep Aang Rahmatullah, S.STP., M.P.',
            'golongan' => 'Pembina Utama Muda',
            'nip'=>'197805211997111001',
            'ttd' => null,
        ],
        [
            'user_id' => 3,
            'nama' => 'Arief Bijaksana Maryugo.S.IP',
            'golongan' => 'Pembina Utama Muda',
            'nip'=>'196808161989031007',
            'ttd' => null,
        ]
    ]);

    Profile::insert([
        [
            'user_id' => 4,
            'nama' => 'BPKAD',
            'ttd' => null,
        ],
        [
            'user_id' => 5,
            'nama' => 'Admin LKM',
            'ttd' => null,
        ],
        [
            'user_id' => 6,
            'nama' => 'Admin BPR',
            'ttd' => null,
        ],
        [
            'user_id' => 7,
            'nama' => 'Admin Perumdam',
            'ttd' => null,
        ],
        [
            'user_id' => 8,
            'nama' => 'Admin Petrogas',
            'ttd' => null,
        ]
    ]);

    }
}
