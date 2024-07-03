<?php

namespace Database\Seeders;

use App\Models\Peserta;
use Illuminate\Database\Seeder;

class PesertaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $peserta = [
            [
                'nama' => 'fahrul',
                'partai' => 'Gerindra',
                'pendukung_calon' => 'paslon 1',
                'foto' => 'QN3e6RZ19KRfqThzDukuFdGMjULVpFNCViXhMuca.png'
            ],
            [
                'nama' => 'ikvi',
                'partai' => 'Golkar',
                'pendukung_calon' => 'paslon 2',
                'foto' => 'OOi5JN3t1nHcOFvVSYMGCqPddLfV7JNnVXad23Pg.jpg'
            ]
        ];

        Peserta::insert($peserta);
    }
}
