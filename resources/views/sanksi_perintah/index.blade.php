@extends('layouts.app')
@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="row">
                <div class="col-xl-12 mb-3 mb-xl-0">

                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center border-0">
                            <div class="me-auto">
                                Daftar Perintah Bentuk Sanksi
                            </div>
                        </div>

                        <!-- Network - Area Chart -->
                        <div class="card-body py-0" style="height: 250px; max-height: 275px">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Bentuk Sanksi</th>
                                            <th>Nama</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($perintah_sanksi as $p)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <a href="{{ url('pengaturan/sanksi', $p->sanksi->id) }}"
                                                        style="text-decoration: none">
                                                        {{ $p->sanksi->nama }}
                                                    </a>
                                                </td>
                                                <td>
                                                    {{ $p->nama }}
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
