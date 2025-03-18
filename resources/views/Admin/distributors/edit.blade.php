@extends('layouts.admin.master')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Edit Akun Distributor</h2>
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

                    <!-- Form Edit Distributor -->
                    <form action="{{ route('distributors.update', $distributors->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Email -->
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control rounded-pill" name="email" 
                                value="{{ old('email', $distributors->email) }}" required>
                        </div>

                        <!-- Phone Number -->
                        <div class="form-group mb-3">
                            <label for="phone" class="form-label">{{ __('Phone Number') }}</label>
                            <input id="phone" type="text" class="form-control rounded-pill" name="phone" 
                                value="{{ old('phone', $distributors->phone) }}" required>
                        </div>

                        <!-- Address -->
                        <div class="form-group mb-3">
                            <label for="address" class="form-label">{{ __('Address') }}</label>
                            <textarea id="address" class="form-control rounded" name="address" required>{{ old('address', $distributors->address) }}</textarea>
                        </div>

                        <!-- Company Name -->
                        <div class="form-group mb-3">
                            <label for="company_name" class="form-label">{{ __('Company Name') }}</label>
                            <input id="company_name" type="text" class="form-control rounded-pill" name="company_name" 
                                value="{{ old('company_name', $distributors->company_name) }}" required>
                        </div>

                        <!-- Name (PIC) -->
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">{{ __('Name (PIC)') }}</label>
                            <input id="name" type="text" class="form-control rounded-pill" name="name" 
                                value="{{ old('name', $distributors->name) }}" required>
                        </div>

                        <!-- PIC's Phone Number -->
                        <div class="form-group mb-3">
                            <label for="pic_phone" class="form-label">{{ __("PIC's Phone Number") }}</label>
                            <input id="pic_phone" type="text" class="form-control rounded-pill" name="pic_phone" 
                                value="{{ old('pic_phone', $distributors->pic_phone) }}" required>
                        </div>

                        <!-- Upload Deed of Establishment -->
                        <div class="form-group mb-3">
                            <label for="deed_of_establishment" class="form-label">{{ __('Upload Deed of Establishment (Akta)') }}</label>
                            <input id="deed_of_establishment" type="file" class="form-control rounded-pill" name="deed_of_establishment">
                            @if ($distributors->deed_of_establishment)
                                <small>File saat ini: <a href="{{ asset($distributors->deed_of_establishment) }}" target="_blank">Lihat Dokumen</a></small>
                            @endif
                        </div>

                        <!-- Upload NIB Document -->
                        <div class="form-group mb-3">
                            <label for="nib_document" class="form-label">{{ __('Upload NIB Document') }}</label>
                            <input id="nib_document" type="file" class="form-control rounded-pill" name="nib_document">
                            @if ($distributors->nib_document)
                                <small>File saat ini: <a href="{{ asset($distributors->nib_document) }}" target="_blank">Lihat Dokumen</a></small>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                        <a href="{{ route('distributors.index') }}" class="btn btn-secondary">Kembali</a>
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
                    <form action="{{ route('distributors.update-password', $distributors->id) }}" method="POST" id="edit-password-form">
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
    </div>

    <!-- JavaScript to Allow Only Numeric Input -->
    <script>
        document.getElementById('phone').addEventListener('input', function (e) {
            e.target.value = e.target.value.replace(/\D/g, '');
        });
        document.getElementById('pic_phone').addEventListener('input', function (e) {
            e.target.value = e.target.value.replace(/\D/g, '');
        });
    </script>
@endsection
