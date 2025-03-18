@extends('layouts.guest.master2')

@section('content')



<div class="container d-flex flex-column justify-content-center align-items-center vh-100">
    <!-- Tombol Switch -->
    <div class="mb-4">
        <div class="btn-group rounded-pill bg-light p-2 shadow-sm" role="group" aria-label="Switch">
            <a href="#" class="btn btn-primary rounded-pill me-2 btn-switch-auth" style="min-width: 150px;">
                {{ __('Masuk') }}
            </a>
            <a href="#" class="btn btn-light rounded-pill btn-switch-auth" data-bs-toggle="modal" data-bs-target="#alertModal" style="min-width: 150px;">
                {{ __('Daftar') }}
            </a>
        </div>
    </div>
    
    <!-- Card Login -->
    <div class="row col-lg-8 col-md-10 col-sm-12 shadow-sm rounded bg-white rounded larger-mobile">
        <!-- Logo Section (Kiri) -->
        <div class="col-md-6 d-none d-md-flex justify-content-center align-items-center bg-light p-5 rounded">
            <a href="{{ route('home') }}">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="img-fluid" style="max-width: 250px;">
            </a>
        </div>

        <!-- Login Form Section (Kanan) -->
        <div class="col-md-6 p-5 rounded">
            <h3 class="text-center mb-4">Login</h3>

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="form-group mb-3">
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter your email" required autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group mb-3">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter your password" required>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>

                <!-- Login Button -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary rounded-pill py-2">
                        {{ __('Login') }}
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>



@include('auth.partials.register')

<div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="alertModalLabel">Informasi Penting</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-center">
                    Pendaftaran ini hanya diperuntukkan bagi distributor yang telah bekerja sama dengan PT Umalo Sedia Tekno.
                    Jika Anda belum menjadi distributor resmi, silakan hubungi kami untuk informasi lebih lanjut.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary w-100 rounded-pill" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#registerModal">
                    Lanjutkan Pendaftaran
                </button>
            </div>
        </div>
    </div>
</div>




<script>
    document.addEventListener('DOMContentLoaded', function () {
    // Bind "Daftar" button in alert modal to open the register modal
    const alertModal = new bootstrap.Modal(document.getElementById('alertModal'));
    const registerModal = new bootstrap.Modal(document.getElementById('registerModal'));

    // Trigger alert modal from "Daftar" button in login page
    document.querySelector('[data-bs-target="#alertModal"]').addEventListener('click', function () {
        alertModal.show();
    });

    // Trigger register modal when "Lanjutkan Pendaftaran" is clicked
    document.querySelector('[data-bs-target="#registerModal"]').addEventListener('click', function () {
        alertModal.hide(); // Hide the alert modal
        registerModal.show(); // Show the register modal
    });
});

</script>


<!-- Script for Multi-Step Navigation -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const steps = document.querySelectorAll('.step');
        let currentStep = 0;

        document.querySelectorAll('.next-btn').forEach((btn) => {
            btn.addEventListener('click', function () {
                steps[currentStep].classList.add('d-none');
                currentStep += 1;
                steps[currentStep].classList.remove('d-none');
            });
        });

        document.querySelectorAll('.prev-btn').forEach((btn) => {
            btn.addEventListener('click', function () {
                steps[currentStep].classList.add('d-none');
                currentStep -= 1;
                steps[currentStep].classList.remove('d-none');
            });
        });
    });
</script>


<!-- Script for SweetAlert2 Notification -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Check for login error from session -->
@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Login Failed',
            text: '{{ session('error') }}',
            confirmButtonText: 'OK',
            confirmButtonColor: '#3085d6'
        });
    </script>
@endif

@endsection
