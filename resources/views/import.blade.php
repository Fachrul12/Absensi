@extends('layouts.main')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Import Peserta</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Import Peserta</li>
                </ol>
            </div>
        </div>
    </div>
    <hr class="m-0">
</div>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card card-primary ml-3 mr-3">
    <div class="card-header">
        <h3 class="card-title">Form Import Peserta</h3>
    </div>
    <form action="{{ route('import.peserta', ['event_id' => $event_id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" required>
        <button type="submit" class="btn btn-success">Import</button>
    </form>
</div>
@endsection
