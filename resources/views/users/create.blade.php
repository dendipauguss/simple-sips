@extends('layouts.app')
@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="row">
                <div class="col-xl-12 mb-3 mb-xl-0">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"></h5>
                            <!-- Horizontal Form -->
                            <form action="{{ url('pengaturan/users') }}" method="POST">
                                @csrf
                                <div class="row mb-3">
                                    <label for="nama" class="col-sm-2 col-form-label">Nama Lengkap</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                            id="nama" name="nama" value="{{ old('nama') }}">
                                        @error('nama')
                                            <div class="invalid-feedback"> {{ $message }} </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="username" class="col-sm-2 col-form-label">Username</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('username') is-invalid @enderror"
                                            id="username" name="username" value="{{ old('username') }}">
                                        @error('username')
                                            <div class="invalid-feedback"> {{ $message }} </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" {{ old('email') }}>
                                        @error('email')
                                            <div class="invalid-feedback"> {{ $message }} </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="role" class="col-sm-2 col-form-label">Role</label>
                                    <div class="col-sm-10">
                                        <select name="role" id="role"
                                            class="form-select @error('role') is-invalid @enderror">
                                            <option value="pegawai" {{ old('role') == 'pegawai' ? 'selected' : '' }}>Pegawai
                                            </option>
                                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin
                                            </option>
                                        </select>
                                        @error('role')
                                            <div class="invalid-feedback"> {{ $message }} </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="password" class="col-sm-2 col-form-label">Kata Sandi</label>
                                    <div class="col-sm-10">
                                        <div class="input-group has-validation">
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror" id="password"
                                                name="password">
                                            <button type="button" id="togglePassword" class="input-group-text">
                                                <i class="psi-eye-visible"></i>
                                            </button>
                                            @error('password')
                                                <div class="invalid-feedback d-block"> {{ $message }} </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                <button onclick="window.history.back()" class="btn btn-sm btn-light"> ⬅ Kembali</button>
                            </form>
                            <!-- END : Horizontal Form -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#togglePassword').on('click', function() {
            const pass = $('#password');

            // Ganti type
            const type = pass.attr('type') === 'password' ? 'text' : 'password';
            pass.attr('type', type);

            // Ganti icon (optional)
            $(this).html(type === 'password' ? '<i class="psi-eye-visible"></i>' :
                '<i class="psi-eye-invisible"></i>');
        });
    </script>
@endsection
