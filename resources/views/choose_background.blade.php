@extends('layouts.main')

@section('content')
<div class="container">
    @if($event->backgrounds === null || count($event->backgrounds) == 0)
        <div class="alert alert-info">Tidak ada background yang dipilih untuk event ini.</div>
        <div class="btn-group">
            <a href="/background" class="btn btn-primary">Pilih Background</a>
            <a href="{{ route('qrcode.download.without.background', ['pesertaId' => $peserta->id, 'returnUrl' => url()->previous()]) }}" class="btn btn-secondary">Download QR Code tanpa Background</a>

        </div>
    @else
        <div class="row">
            @foreach ($event->backgrounds as $background)
                <div class="col-md-3">
                    <div class="card">
                        <img src="{{ asset('storage/backgrounds/' . $background->image) }}" alt="Background Image" class="card-img-top">
                        <div class="card-body">
                            <a href="{{ route('background.assign', ['background_id' => $background->id, 'event_id' => $event->id]) }}" class="btn btn-primary">Pilih Background ini</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection