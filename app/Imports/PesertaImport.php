<?php

namespace App\Imports;

use App\Models\Peserta;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\IsiKategoriPeserta;

class PesertaImport implements ToModel, WithHeadingRow
{
    protected $event_id;

    public function __construct($event_id)
    {
        $this->event_id = $event_id;
    }

    public function model(array $row)
{
    // Cari ID berdasarkan nama 'isi_kategori_peserta'
    $isiKategoriPeserta = IsiKategoriPeserta::where('nama_isi_kategori_peserta', $row['isi_kategori_peserta'])->first();

    // Jika tidak ditemukan, beri nilai default atau tangani kesalahan
    if (!$isiKategoriPeserta) {
        throw new \Exception("isi kategori peserta '{$row['isi_kategori_peserta']}' tidak ditemukan");
    }

    return new Peserta([
        'nama_peserta' => $row['nama'],
        'foto_peserta' => $row['foto'],
        'event_id' => $this->event_id,
        'isi_kategori_peserta_id' => $isiKategoriPeserta->id,
        // Anda bisa menambahkan field lain sesuai kebutuhan
    ]);
}
}
