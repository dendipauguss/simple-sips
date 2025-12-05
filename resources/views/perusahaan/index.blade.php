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
                                        <a href="{{ url('perusahaan/create') }}" class="btn btn-sm btn-primary">+ Tambah</a>
                                        <a href="{{ url('perusahaan/import') }}" class="btn btn-sm btn-success">+ Import
                                            Excel</a>
                                    </div>
                                </div>
                            @endif
                            <form class="row row-cols-md-auto g-3 align-items-center" action="{{ url('perusahaan') }}"
                                method="GET">
                                <div class="col-12">
                                    {{-- <input type="date" class="form-control" id="tanggal_selesai" name="end"
                                        value="{{ request('end') }}"> --}}
                                    <select name="jenis_perusahaan" id="jenis_perusahaan" class="form-select">
                                        <option value="">Jenis Perusahaan</option>
                                        @foreach ($jenis_perusahaan as $jp)
                                            <option value="{{ $jp->id }}">{{ $jp->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                                    <a href="{{ url('perusahaan') }}" class="btn btn-sm btn-light">Reset</a>
                                </div>
                            </form>
                        </div>
                        <div class="card-body py-0">
                            <div class="table-responsive">
                                <table class="table table-hover" id="dataTables">
                                    <thead class="table-primary">
                                        <tr>
                                            <th class="text-dark text-center">No</th>
                                            <th class="text-dark text-center">Nama Perusahaan</th>
                                            <th class="text-dark text-center">Jenis Perusahaan</th>
                                            <th class="text-dark text-center" style="width: 15%;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($perusahaan as $p)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $p->nama }}</td>
                                                <td>
                                                    {{ $p->jenis_perusahaan->nama }}
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('perusahaan.show', $p->id) }}"
                                                            class="badge bg-info me-1 text-decoration-none" title="Detail">
                                                            Detail <i class="psi-paper"></i>
                                                        </a>
                                                        @if (auth()->user()->role == 'admin')
                                                            <a href="{{ route('perusahaan.edit', $p->id) }}"
                                                                class="badge bg-warning me-1 text-decoration-none"
                                                                title="Edit">
                                                                Edit <i class="psi-pencil"></i>
                                                            </a>
                                                            <a href="#" class="badge bg-danger text-decoration-none"
                                                                onclick="event.preventDefault(); document.getElementById('delete-{{ $p->id }}').submit();">
                                                                Hapus <i class="psi-trash"></i>
                                                            </a>

                                                            <form id="delete-{{ $p->id }}"
                                                                action="{{ route('perusahaan.destroy', $p->id) }}"
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
