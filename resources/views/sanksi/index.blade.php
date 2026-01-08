@extends('layouts.app')
@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="row">
                <div class="col-xl-12 mb-3 mb-xl-0">

                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center border-0">
                            <div class="me-auto">
                                <a href="{{ url('pengaturan/sanksi/create') }}" class="btn btn-sm btn-primary">+ Tambah</a>
                            </div>
                        </div>

                        <!-- Network - Area Chart -->
                        <div class="card-body py-0">
                            <div class="table-responsive">
                                <table class="table table-striped" id="dataTables">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Kode Sanksi</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sanksi as $p)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <a href="{{ url('pengaturan/sanksi', $p->id) }}"
                                                        style="text-decoration: none">
                                                        {{ $p->nama }}
                                                    </a>
                                                </td>
                                                <td>{{ $p->kode_surat }}</td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('sanksi.show', $p->id) }}"
                                                            class="badge bg-info me-1 text-decoration-none" title="Detail">
                                                            Detail <i class="psi-paper"></i>
                                                        </a>
                                                        @if (auth()->user()->role == 'admin')
                                                            <a href="{{ route('sanksi.edit', $p->id) }}"
                                                                class="badge bg-warning me-1 text-decoration-none"
                                                                title="Edit">
                                                                Edit <i class="psi-pencil"></i>
                                                            </a>
                                                            <a href="#" class="badge bg-danger text-decoration-none"
                                                                onclick="event.preventDefault(); if(confirm('Yakin ingin menghapus data ini?')) document.getElementById('delete-{{ $p->id }}').submit();">
                                                                Hapus <i class="psi-trash"></i>
                                                            </a>

                                                            <form id="delete-{{ $p->id }}"
                                                                action="{{ route('sanksi.destroy', $p->id) }}"
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
                        <!-- END : Network - Area Chart -->
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
