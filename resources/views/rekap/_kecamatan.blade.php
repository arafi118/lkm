@extends('rekap.layout.base')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="alert alert-danger text-center">
                <h3 class="text-light">{{ $kec->nama }} Belum Menggunakan SI LKM v8.23-a2</h3>
            </div>
        </div>
    </div>
@endsection
