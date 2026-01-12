@extends('layouts.app')
@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="row">
                <div class="col-xl-7 mb-3 mb-xl-0">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center border-0">
                            <a href="{{ route('kategori-sp.index') }}" class="btn btn-sm btn-dark"> ⬅ Kembali</a>
                        </div>
                        <div class="card-body py-4">
                            <ul class="list-group">
                                <li class="list-group-item d-flex">
                                    <strong class="me-3" style="width: 150px;">Jenis Pelanggaran</strong>
                                    <span>:
                                        {{ $kategori_sp->jenis_pelanggaran->nama }}</span>
                                </li>
                                <li class="list-group-item d-flex">
                                    <strong class="me-3" style="width: 150px;">Nama</strong>
                                    <span>:
                                        {{ $kategori_sp->nama }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
