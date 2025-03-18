@extends('layouts.admin.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Edit Data Diri</h2>
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

                    <!-- Form untuk Edit Data Diri -->
                    <form action="{{ route('members.update', $member->id) }}" method="POST" id="edit-data-diri-form">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Nama :</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $member->name) }}" required>
                            @if ($errors->has('name'))
                                <small class="text-danger">{{ $errors->first('name') }}</small>
                            @endif
                        </div>

                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email :</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $member->email) }}" required>
                            @if ($errors->has('email'))
                                <small class="text-danger">{{ $errors->first('email') }}</small>
                            @endif
                        </div>

                        <div class="form-group mb-3">
                            <label for="company_name" class="form-label">Nama Perusahaan :</label>
                            <input type="text" class="form-control" id="company_name" name="company_name" value="{{ old('company_name', $member->company_name) }}">
                            @if ($errors->has('company_name'))
                                <small class="text-danger">{{ $errors->first('company_name') }}</small>
                            @endif
                        </div>

                        <div class="form-group mb-3">
                            <label for="phone" class="form-label">Nomor Telepon :</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $member->phone) }}" 
                                   pattern="[0-9]*" inputmode="numeric" minlength="8" maxlength="15" required>
                            @if ($errors->has('phone'))
                                <small class="text-danger">{{ $errors->first('phone') }}</small>
                            @endif
                        </div>
                        

                        <div class="form-group mb-3">
                            <label for="address" class="form-label">Alamat :</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $member->address) }}">
                            @if ($errors->has('address'))
                                <small class="text-danger">{{ $errors->first('address') }}</small>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-success">Perbaharui Data Diri</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h2>Edit Password</h2>
                </div>
                <div class="card-body">
                    <!-- Form untuk Edit Password -->
                    <form action="{{ route('members.update-password', $member->id) }}" method="POST" id="edit-password-form">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="password" class="form-label">Password Baru :</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <small class="text-danger" id="password_error"></small>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru :</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                            <small class="text-danger" id="password_confirmation_error"></small>
                        </div>
        
                        <button type="submit" class="btn btn-warning" id="submit-password-btn" style="display: none;">Perbaharui Password</button>
                    </form>
                </div>
            </div>
        </div>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const passwordField = document.getElementById('password');
                const passwordConfirmField = document.getElementById('password_confirmation');
                const submitButton = document.getElementById('submit-password-btn');
                const passwordError = document.getElementById('password_error');
        
                function toggleSubmitButton() {
                    if (passwordField.value && passwordConfirmField.value) {
                        if (passwordField.value === passwordConfirmField.value) {
                            passwordError.textContent = '';  // Clear any error
                            submitButton.style.display = 'block';
                        } else {
                            passwordError.textContent = 'Password dan konfirmasi tidak cocok';  // Show mismatch error
                            submitButton.style.display = 'none';  // Hide the submit button
                        }
                    } else {
                        passwordError.textContent = '';  // Clear error if fields are empty
                        submitButton.style.display = 'none';  // Hide the submit button
                    }
                }
        
                passwordField.addEventListener('input', toggleSubmitButton);
                passwordConfirmField.addEventListener('input', toggleSubmitButton);
            });
        </script>

<script>
    document.getElementById('no_telp').addEventListener('input', function (e) {
        // Hanya izinkan angka, hapus karakter yang bukan angka
        e.target.value = e.target.value.replace(/\D/g, '');
    });
</script>

        
        
        
    </div>

    <div class="row justify-content-center mt-3">
        <div class="col-md-12">
            <a href="{{ route('members.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
