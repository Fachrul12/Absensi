<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Absen;

class AbsensiController extends Controller
{
    public function store(Request $request)
    {
        //cek data
        $cek = Absen::where([
            'id_peserta' => $request->id_peserta,
            'tanggal' => date('Y-m-d')
        ])->first();

        if ($cek){
            return redirect('/')->with('gagal','Anda sudah absen');
        }

        Absen::create([
            'id_peserta' => $request->id_peserta,
            'tanggal' => date('Y-m-d')
        ]);

        return redirect('/')->with('Success','Silahkan masuk');
    }
}
