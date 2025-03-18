@extends('layouts.distributor.master')

@section('content')

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h4>Profil Anda</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('distributor.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Profile Photo -->
                        <div class="mb-3 text-center">
                            <label for="profile_photo" class="form-label">Foto Profil</label>
                            <div class="d-flex justify-content-center">
                                <img 
                                    src="{{ $user->profile_photo ? asset($user->profile_photo) : 'https://via.placeholder.com/150' }}" 
                                    alt="Profile Photo" 
                                    class="rounded-circle border" 
                                    style="width: 150px; height: 150px; object-fit: cover;">
                            </div>
                            <input type="file" name="profile_photo" id="profile_photo" class="form-control mt-2">
                        </div>

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Kata Sandi (Opsional)</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah">
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Masukkan kembali kata sandi">
                        </div>

                        <!-- Company Name -->
                        <div class="mb-3">
                            <label for="company_name" class="form-label">Nama Perusahaan</label>
                            <input type="text" name="company_name" id="company_name" class="form-control" value="{{ $user->company_name }}">
                        </div>

                        <!-- Phone -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">Telepon</label>
                            <input type="text" name="phone" id="phone" class="form-control" value="{{ $user->phone }}">
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <textarea name="address" id="address" class="form-control" rows="3">{{ $user->address }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Perbarui Profil</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
