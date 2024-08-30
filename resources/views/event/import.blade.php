@extends('layouts.main')

@section('content')
<div class="container">
    <h1>Import Event</h1>
    <hr>
    <form action="{{ route('events.import') }}" method="POST" enctype="multipart/form-data" class="d-inline-block">
        @csrf
        <input type="file" name="import_file" class="form-control-file">
        <button type="submit" class="btn btn-success btn-sm">
            <i class="fas fa-upload"></i> Import JSON
        </button>
    </form>
</div>
@endsection
