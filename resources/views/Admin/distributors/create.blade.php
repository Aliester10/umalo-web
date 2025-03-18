@extends('layouts.admin.master')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>Buat Akun Distributor</h2>
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

                    <form action="{{ route('distributors.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Email -->
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control rounded-pill" name="email" placeholder="Enter your email" value="{{ old('email') }}" required>
                        </div>

                        <!-- Phone Number -->
                        <div class="form-group mb-3">
                            <label for="phone" class="form-label">{{ __('Phone Number') }}</label>
                            <input id="phone" type="text" class="form-control rounded-pill" name="phone" placeholder="Enter your phone number" value="{{ old('phone') }}" required>
                        </div>

                        <!-- Address -->
                        <div class="form-group mb-3">
                            <label for="address" class="form-label">{{ __('Address') }}</label>
                            <textarea id="address" class="form-control rounded" name="address" placeholder="Enter your address" required>{{ old('address') }}</textarea>
                        </div>

                        <!-- Company Name -->
                        <div class="form-group mb-3">
                            <label for="company_name" class="form-label">{{ __('Company Name') }}</label>
                            <input id="company_name" type="text" class="form-control rounded-pill" name="company_name" placeholder="Enter your company name" value="{{ old('company_name') }}" required>
                        </div>

                        <!-- Name (PIC) -->
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">{{ __('Name (PIC)') }}</label>
                            <input id="name" type="text" class="form-control rounded-pill" name="name" placeholder="Enter PIC's name" value="{{ old('name') }}" required>
                        </div>

                        <!-- PIC's Phone Number -->
                        <div class="form-group mb-3">
                            <label for="pic_phone" class="form-label">{{ __("PIC's Phone Number") }}</label>
                            <input id="pic_phone" type="text" class="form-control rounded-pill" name="pic_phone" placeholder="Enter PIC's phone number" value="{{ old('pic_phone') }}" required>
                        </div>

                        <!-- Upload Deed of Establishment -->
                        <div class="form-group mb-3">
                            <label for="deed_of_establishment" class="form-label">{{ __('Upload Deed of Establishment (Akta)') }}</label>
                            <input id="deed_of_establishment" type="file" class="form-control rounded-pill" name="deed_of_establishment" required>
                        </div>

                        <!-- Upload NIB Document -->
                        <div class="form-group mb-3">
                            <label for="nib_document" class="form-label">{{ __('Upload NIB Document') }}</label>
                            <input id="nib_document" type="file" class="form-control rounded-pill" name="nib_document" required>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <a href="{{ route('distributors.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
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
