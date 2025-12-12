@extends('layouts.app')
@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="row">
                <div class="col-xl-7 mb-3 mb-xl-0">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center border-0">
                            <a href="{{ route('laporan.index') }}" class="btn btn-sm btn-dark"> ⬅ Kembali</a>
                        </div>
                        <div class="card-body py-4">
                            <h4>Laporan Bulan {{ DateTime::createFromFormat('!m', $laporan->bulan)->format('F') }}
                                {{ $laporan->tahun }}</h4>

                            <a href="{{ route('laporan.pdf', $laporan->id) }}" class="btn btn-sm btn-primary mb-3"
                                target="_blank">Lihat
                                PDF</a>

                            @foreach ($items as $kategori => $rows)
                                <h5 class="mt-4">{{ $kategori }}</h5>

                                <table class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th>Nama Perusahaan</th>
                                            <th>Bentuk Sanksi</th>
                                            <th>Pelanggaran</th>
                                            <th>Tanggapan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rows as $sp)
                                            <tr>
                                                <td>{{ $sp->pelaku_usaha->nama }}</td>
                                                <td>{{ $sp->bentuk_sanksi }}</td>
                                                <td>{{ $sp->pelanggaran }}</td>
                                                <td>{{ $sp->tanggapan ?? 'Belum Ditanggapi' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endforeach
                        </div>
                    </div>
                </div>
                {{-- <div class="col-xl">
                    <div class="card h-100">
                        <div class="card-body py-4">
                            <iframe src="{{ asset($sp->file->url_path) }}" frameborder="0" width="100%"
                                height="600px"></iframe>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
@endsection
