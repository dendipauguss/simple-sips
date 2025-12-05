@extends('layouts.app')
@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="row">
                <div class="col-xl-12 mb-3 mb-xl-0">

                    <div class="card h-100">

                        <!-- Network - Area Chart -->
                        <div class="card-body py-0" style="height: 250px; max-height: 275px">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $perusahaan->nama }}</td>
                                            <td>
                                                {{ $perusahaan->alamat }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- END : Network - Area Chart -->
                        <div class="card-footer d-flex align-items-center border-0">
                            <button onclick="window.history.back()" class="btn btn-sm btn-dark"> ⬅ Kembali</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
