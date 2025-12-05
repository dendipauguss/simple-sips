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
                                        <a href="{{ url('pelaku-usaha/create') }}" class="btn btn-sm btn-primary">+ Tambah</a>
                                        <a href="{{ url('pelaku-usaha/import') }}" class="btn btn-sm btn-success">+ Import
                                            Excel</a>
                                    </div>
                                </div>
                            @endif
                            <form class="row row-cols-md-auto g-3 align-items-center" action="{{ url('pelaku-usaha') }}"
                                method="GET">
                                <div class="col-12">
                                    {{-- <input type="date" class="form-control" id="tanggal_selesai" name="end"
                                        value="{{ request('end') }}"> --}}
                                    <select name="jenis_pelaku_usaha" id="jenis_pelaku_usaha" class="form-select">
                                        <option>-- Jenis Pelaku Usaha --</option>
                                        @foreach ($jenis_pelaku_usaha as $jp)
                                            <option value="{{ $jp->id }}"
                                                {{ request('jenis_pelaku_usaha') == $jp->id ? 'selected' : '' }}>
                                                {{ $jp->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                                    <a href="{{ url('pelaku-usaha') }}" class="btn btn-sm btn-light">Reset</a>
                                </div>
                            </form>
                        </div>
                        <div class="card-body py-0">
                            <div class="table-responsive">
                                <table class="table table-hover" id="dataTables">
                                    <thead class="table-primary">
                                        <tr>
                                            <th class="text-dark text-center">No</th>
                                            <th class="text-dark text-center">Nama Pelaku Usaha</th>
                                            <th class="text-dark text-center">Jenis Pelaku Usaha</th>
                                            <th class="text-dark text-center" style="width: 15%;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pelaku_usaha as $p)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $p->nama }}</td>
                                                <td>
                                                    {{ $p->jenis_pelaku_usaha->nama }}
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('pelaku-usaha.show', $p->id) }}"
                                                            class="badge bg-info me-1 text-decoration-none" title="Detail">
                                                            Detail <i class="psi-paper"></i>
                                                        </a>
                                                        @if (auth()->user()->role == 'admin')
                                                            <a href="{{ route('pelaku-usaha.edit', $p->id) }}"
                                                                class="badge bg-warning me-1 text-decoration-none"
                                                                title="Edit">
                                                                Edit <i class="psi-pencil"></i>
                                                            </a>
                                                            <a href="#" class="badge bg-danger text-decoration-none"
                                                                onclick="event.preventDefault(); if(confirm('Yakin ingin menghapus data ini?')) document.getElementById('delete-{{ $p->id }}').submit();">
                                                                Hapus <i class="psi-trash"></i>
                                                            </a>

                                                            <form id="delete-{{ $p->id }}"
                                                                action="{{ route('pelaku-usaha.destroy', $p->id) }}"
                                                                method="POST" style="display:none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
