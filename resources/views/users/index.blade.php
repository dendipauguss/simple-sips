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
                                        <a href="{{ url('pengaturan/users/create') }}" class="btn btn-sm btn-primary">+
                                            Tambah</a>
                                        {{-- <a href="{{ url('jenis-pelaku-usaha/import') }}" class="btn btn-sm btn-success">+
                                            Import
                                            Excel</a> --}}
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="card-body py-0">
                            <div class="table-responsive">
                                <table class="table table-hover" id="dataTables">
                                    <thead class="table-dark">
                                        <tr>
                                            <th class="text-center" style="width: 5%;">No</th>
                                            <th class="text-center">Nama</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Username</th>
                                            <th class="text-center">Role</th>
                                            <th class="text-center" style="width: 15%;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    {{ $user->nama }}
                                                </td>
                                                <td>
                                                    {{ $user->email }}
                                                </td>
                                                <td>
                                                    {{ $user->username }}
                                                </td>
                                                <td>
                                                    {{ ucfirst($user->role) }}
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('users.show', $user->id) }}"
                                                            class="badge bg-info me-1 text-decoration-none" title="Detail">
                                                            Detail <i class="psi-paper"></i>
                                                        </a>
                                                        @if (auth()->user()->role == 'admin')
                                                            <a href="{{ route('users.edit', $user->id) }}"
                                                                class="badge bg-warning me-1 text-decoration-none"
                                                                title="Edit">
                                                                Edit <i class="psi-pencil"></i>
                                                            </a>
                                                            <a href="#" class="badge bg-danger text-decoration-none"
                                                                onclick="event.preventDefault(); if(confirm('Yakin ingin menghapus data ini?')) document.getElementById('delete-{{ $user->id }}').submit();">
                                                                Hapus <i class="psi-trash"></i>
                                                            </a>

                                                            <form id="delete-{{ $user->id }}"
                                                                action="{{ route('users.destroy', $user->id) }}"
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
