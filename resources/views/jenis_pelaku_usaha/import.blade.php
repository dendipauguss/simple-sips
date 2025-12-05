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
                        <div class="card-header">Import Excel Data Perusahaan</div>
                        <div class="card-body">
                            <form action="{{ route('perusahaan.import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Upload File Excel</label>
                                    <input type="file" name="file" class="form-control" required>
                                    @error('file')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button class="btn btn-primary">Import</button>
                                <a href="{{ route('perusahaan.index') }}" class="btn btn-light">⬅️ Kembali</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
