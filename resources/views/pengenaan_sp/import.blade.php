@extends('layouts.app')
@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="row">
                <div class="col-xl-12 mb-3 mb-xl-0">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <div class="alert alert-info">
                                Untuk format import excel harus seperti ini :
                            </div>
                            <div class="row">
                                <div class="col">
                                    <img src="/img/format_import_excel_pelaku_usaha.png" alt="Format excel"
                                        class="img-fluid">
                                </div>
                                {{-- <div class="col">
                                    <h6>Jenis Pelaku Usaha yang terdaftar</h6>
                                    <ul class="list-group list-group-borderless">
                                        @foreach ($jenis_pelaku_usaha as $jp)
                                            <li class="list-group-item list-group-item-action" style="font-size: 10px">
                                                {{ $loop->iteration }}. {{ $jp->nama }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('pengenaan-sp.import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Upload File Excel</label>
                                    <input type="file" name="file" class="form-control" required>
                                    @error('file')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button class="btn btn-primary">Import</button>
                                <a href="{{ route('pengenaan-sp.index') }}" class="btn btn-light">⬅️ Kembali</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
