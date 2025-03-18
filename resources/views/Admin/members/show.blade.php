@extends('layouts.admin.master')

@section('content')

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif (session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2>Detail Member</h2>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Nama</th>
                            <td>{{ $member->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $member->email }}</td>
                        </tr>
                        <tr>
                            <th>Nama Perusahaan</th>
                            <td>{{ $member->company_name }}</td>
                        </tr>
                        <tr>
                            <th>Nomor Telepon</th>
                            <td>{{ $member->phone }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $member->address }}</td>
                        </tr>
                    </tbody>
                </table>

                
                </div>
                </div>

                <div class="mb-3">
                    <div class="card p-4 shadow">
                        <div class="card-header">
                    <h4>Pemilik Produk</h4>
                </div>
                <div class="card-body">
                    @if($member->usersProduct->isEmpty())
                        <p>Member ini tidak memiliki produk.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Gambar</th>
                                        <th>Nama Produk</th>
                                        <th>Tanggal Pembelian</th>
                                        <th>Jumlah</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($member->usersProduct as $index => $userProduct)
                                        @php
                                            $firstImage = $userProduct->product->images->first();
                                            $imageSrc = $firstImage ? $firstImage->images : 'assets/img/default.jpg';
                                        @endphp
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <img src="{{ asset($imageSrc) }}" alt="{{ $userProduct->product->name }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;">
                                            </td>
                                            <td>{{ $userProduct->product->name }}</td>
                                            <td>{{ $userProduct->purchase_date ?? 'N/A' }}</td>
                                            <td>{{ $userProduct->quantity ?? 1 }}</td>
                                            <td>
                                                <div class="dropdown member-actions-dropdown">
                                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton-{{ $userProduct->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu member-actions-menu" aria-labelledby="dropdownMenuButton-{{ $userProduct->id }}">
                                                        <li>
                                                            <a href="{{ route('members.products.documentation.add', $userProduct->id) }}" class="dropdown-item">
                                                                <i class="fas fa-plus-circle me-2"></i> Tambah Dokumentasi
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('members.products.documentation.list', $userProduct->id) }}" class="dropdown-item">
                                                                <i class="fas fa-eye me-2"></i> Lihat Dokumentasi
                                                            </a>
                                                        </li>
                                                    </ul>.

                                                    <style>
                                                             /* Dropdown khusus untuk Member Actions */
                                                            .member-actions-dropdown .member-actions-menu {
                                                                position: fixed !important; /* Mengabaikan parent container */
                                                                z-index: 1050 !important;   /* Memastikan berada di atas elemen lain */
                                                                will-change: transform;    /* Memperbaiki posisi animasi jika ada */
                                                            }

                                                            /* Tambahkan spesifikasi jika perlu */
                                                            .member-actions-dropdown .dropdown-toggle {
                                                                cursor: pointer;
                                                            }
                                                    </style>
                                                </div>
                                            </td>
                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
                <a href="{{ route('members.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>
</div>


    <!-- Password Modal -->
    @if(isset($password))
    <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="passwordModalLabel">Password Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p>Password baru Anda adalah:</p>
                    <div class="card bg-light p-3 mx-auto" style="max-width: 300px;">
                        <div class="d-flex justify-content-center align-items-center">
                            <strong id="modal-password" class="me-2">{{ $password }}</strong>
                            <i class="fas fa-copy" style="cursor: pointer;" onclick="copyPassword()" title="Copy Password"></i>
                        </div>
                    </div>
                    <p class="text-danger mt-3">Catatan: Harap simpan password ini dengan baik, karena password tidak akan ditampilkan lagi setelah ini.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    @endif
    

<style>
    /* Optional: Adjust the size and style of the copy icon */
    .fas.fa-copy {
        font-size: 1.5rem; /* Adjust the icon size */
        color: #000000; /* Make the icon the same color as the button */
    }
    .fas.fa-copy:hover {
        color: #152c44; /* Change color on hover */
    }
</style>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Show password modal if password is present
        @if(isset($password))
            var passwordModal = new bootstrap.Modal(document.getElementById('passwordModal'));
            passwordModal.show();
        @endif
    });

    function copyPassword() {
        var passwordText = document.getElementById('modal-password').textContent;
        navigator.clipboard.writeText(passwordText).then(function() {
            // Change icon to indicate the copy was successful
            var copyIcon = document.querySelector('.fas.fa-copy');
            copyIcon.classList.remove('fa-copy');
            copyIcon.classList.add('fa-check'); // Change to check icon
            copyIcon.title = "Password berhasil disalin"; // Tooltip change
        }, function() {
            // Optionally handle failure silently
            console.error('Gagal menyalin password');
        });
    }
</script>


@endsection
