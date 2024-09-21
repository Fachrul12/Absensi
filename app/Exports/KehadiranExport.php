<?php

namespace App\Exports;

use App\Models\PesertaHadir;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class KehadiranExport implements FromCollection, WithHeadings
{
    protected $eventId;

    public function __construct($eventId)
    {
        $this->eventId = $eventId;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return PesertaHadir::where('event_id', $this->eventId)
            ->with('peserta') // Eager load the 'peserta' relationship
            ->get()
            ->map(function ($kehadiran) {
                $tanggalHadir = $kehadiran->tanggal_hadir ? Carbon::parse($kehadiran->tanggal_hadir) : null;

                return [
                    'ID' => $kehadiran->id,
                    'Nama Peserta' => $kehadiran->peserta->nama_peserta ?? 'N/A',                
                    'Status Kehadiran' => $kehadiran->tanggal_hadir ? 'Hadir' : 'Tidak Hadir',
                    'Tanggal Kehadiran' => $tanggalHadir ? $tanggalHadir->format('Y-m-d') : 'N/A'
                ];
            });
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nama Peserta',            
            'Status Kehadiran',
            'Tanggal Kehadiran'
        ];
    }
}
