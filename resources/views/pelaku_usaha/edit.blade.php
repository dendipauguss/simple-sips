@extends('layouts.app')
@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="row">
                <div class="col-xl-12 mb-3 mb-xl-0">

                    <div class="card h-100">
                        <div class="card-body">

                            <form action="{{ route('pelaku-usaha.update', $pelaku_usaha->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label">Nama Pelaku Usaha</label>
                                    <input type="text" name="nama" class="form-control"
                                        value="{{ $pelaku_usaha->nama }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Jenis Pelaku Usaha</label>
                                    <select name="jenis_id" id="jenis_id" class="form-select">
                                        @foreach ($jenis_pelaku_usaha as $jp)
                                            @if ($jp->id == $pelaku_usaha->jenis_id)
                                                <option value="{{ $jp->id }}" selected>{{ $jp->nama }}</option>
                                            @else
                                                <option value="{{ $jp->id }}">{{ $jp->nama }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                {{-- <div class="mb-3">
                                    <label class="form-label">Alamat</label>
                                    <textarea name="alamat" class="form-control" required>{{ $pelaku_usaha->alamat }}</textarea>
                                </div> --}}


                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('pelaku-usaha.index') }}" class="btn btn-secondary">Kembali</a>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
