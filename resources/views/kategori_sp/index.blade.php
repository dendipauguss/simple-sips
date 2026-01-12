@extends('layouts.app')
@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="row">
                <div class="col-xl-12 mb-3 mb-xl-0">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center border-0">
                            @if (auth()->user()->role == 'admin')
                                <div class="row row-cols-md-auto">
                                    <div class="input-group me-2">
                                        <a href="{{ url('pengaturan/kategori-sp/create') }}" class="btn btn-sm btn-primary">+
                                            Tambah</a>
                                        <a href="{{ url('pengaturan/kategori-sp/import') }}"
                                            class="btn btn-sm btn-success">+ Import
                                            Excel</a>
                                    </div>
                                </div>
                            @endif
                            <form class="row row-cols-md-auto g-3 align-items-center"
                                action="{{ url('pengaturan/kategori-sp') }}" method="GET">
                                <div class="col-12">
                                    <select name="jenis_pelanggaran" id="jenis_pelanggaran" class="form-select">
                                        <option>-- Jenis Pelanggaran --</option>
                                        @foreach ($jenis_pelanggaran as $jp)
                                            <option value="{{ $jp->id }}"
                                                {{ request('jenis_pelanggaran') == $jp->id ? 'selected' : '' }}>
                                                {{ $jp->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                                    <a href="{{ url('pengaturan/kategori-sp') }}" class="btn btn-sm btn-light">Reset</a>
                                </div>
                            </form>
                        </div>

                        <!-- Network - Area Chart -->
                        <div class="card-body py-0">
                            <div class="table-responsive">
                                <table class="table table-striped" id="dataTables">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Jenis Pelanggaran</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kategori_sp as $ksp)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    {{ $ksp->nama }}
                                                </td>
                                                <td>
                                                    {{ $ksp->jenis_pelanggaran->nama }}
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('kategori-sp.show', $ksp->id) }}"
                                                            class="badge bg-info me-1 text-decoration-none" title="Detail">
                                                            Detail <i class="psi-paper"></i>
                                                        </a>
                                                        <a href="{{ route('kategori-sp.edit', $ksp->id) }}"
                                                            class="badge bg-warning me-1 text-decoration-none"
                                                            title="Edit">
                                                            Edit <i class="psi-pencil"></i>
                                                        </a>
                                                        <a href="#" class="badge bg-danger text-decoration-none"
                                                            onclick="event.preventDefault(); if(confirm('Yakin ingin menghapus data ini?')) document.getElementById('delete-{{ $ksp->id }}').submit();">
                                                            Hapus <i class="psi-trash"></i>
                                                        </a>

                                                        <form id="delete-{{ $ksp->id }}"
                                                            action="{{ route('kategori-sp.destroy', $ksp->id) }}"
                                                            method="POST" style="display:none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- END : Network - Area Chart -->\
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
