<?php

namespace App\Exports;

use App\Models\Peserta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PesertaExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Peserta::with('PesertaHadir:peserta_id,tanggal_hadir') // eager load 'hadir' relationship with only 'peserta_id' and 'status'
            ->get()
            ->map(function ($peserta) {
                return [
                    'id' => $peserta->id,
                    'foto' => $peserta->foto_peserta,
                    'nama' => $peserta->nama_peserta,
                    'kategori_peserta' => $peserta->IsiKategoriPeserta->KategoriPeserta->nama_kategori_peserta,
                    'nama_kategori_peserta' => $peserta->IsiKategoriPeserta->nama_isi_kategori_peserta,
                    'status' => $peserta->PesertaHadir ? 'hadir' : 'tidak hadir'
                ];
            });
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Foto',
            'Nama',
            'Kategori Peserta',
            'isi kategori peserta',
            'Status'
        ];
    }
}
