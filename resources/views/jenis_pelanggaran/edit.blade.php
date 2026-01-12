@extends('layouts.app')
@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="row">
                <div class="col-xl-12 mb-3 mb-xl-0">
                    <div class="card h-100">
                        <div class="card-body">
                            <form action="{{ route('jenis-pelanggaran.update', $jenis_pelanggaran->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label class="form-label">Nama Jenis Pelanggaran</label>
                                    <select name="dasar_pengenaan_sanksi_id" id="dasar_pengenaan_sanksi_id"
                                        class="form-select @error('dasar_pengenaan_sanksi_id') is-invalid @enderror">
                                        @php
                                            $selected = old(
                                                'dasar_pengenaan_sanksi_id',
                                                $jenis_pelanggaran->dasar_pengenaan_sanksi_id,
                                            );
                                        @endphp
                                        @foreach ($dasar_pengenaan_sanksi as $dps)
                                            <option value="{{ $dps->id }}"
                                                {{ $selected == $dps->id ? 'selected' : '' }}>{{ $dps->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('dasar_pengenaan_sanksi_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nama Jenis Pelanggaran</label>
                                    <input type="text" name="nama"
                                        class="form-control @error('nama') is-invalid @enderror"
                                        value="{{ old('nama', $jenis_pelanggaran->nama) }}">
                                    @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('jenis-pelanggaran.index') }}" class="btn btn-light">⬅ Kembali</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
