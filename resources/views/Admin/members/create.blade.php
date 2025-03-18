@extends('layouts.admin.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>Buat Akun Member</h2>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('members.store') }}" method="POST">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Nama :</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                            @if ($errors->has('name'))
                                <small class="text-danger">{{ $errors->first('name') }}</small>
                            @endif
                        </div>

                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email :</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                            @if ($errors->has('email'))
                                <small class="text-danger">{{ $errors->first('email') }}</small>
                            @endif
                        </div>

                        <div class="form-group mb-3">
                            <label for="company_name" class="form-label">Nama Perusahaan :</label>
                            <input type="text" class="form-control" id="company_name" name="company_name" value="{{ old('company_name') }}" required>
                            @if ($errors->has('company_name'))
                                <small class="text-danger">{{ $errors->first('company_name') }}</small>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for="phone" class="form-label">Nomor Telepon :</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" 
                                   pattern="[0-9]*" inputmode="numeric" minlength="8" maxlength="15" required>
                            @if ($errors->has('phone'))
                                <small class="text-danger">{{ $errors->first('phone') }}</small>
                            @endif
                        </div>
                        

                        <div class="form-group mb-3">
                            <label for="address" class="form-label">Alamat :</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}">
                            @if ($errors->has('address'))
                                <small class="text-danger">{{ $errors->first('address') }}</small>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-success">Simpan</button>
                        <a href="{{ route('members.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    <script>
        document.getElementById('no_telp').addEventListener('input', function (e) {
            // Hanya izinkan angka, hapus karakter yang bukan angka
            e.target.value = e.target.value.replace(/\D/g, '');
        });
    </script>
    
@endsection
