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

    <div class="row justify-content-center">
        <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2>Detail Distributor</h2>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Email</th>
                            <td>{{ $distributors->email }}</td>
                        </tr>
                        <tr>
                            <th>Nama Perusahaan</th>
                            <td>{{ $distributors->company_name }}</td>
                        </tr>
                        <tr>
                            <th>Nomor Telepon</th>
                            <td>{{ $distributors->phone }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $distributors->address }}</td>
                        </tr>
                        <tr>
                            <th>Nama PIC</th>
                            <td>{{ $distributors->name }}</td>
                        </tr>
                        <tr>
                            <th>Nomor Telepon PIC</th>
                            <td>{{ $distributors->pic_phone }}</td>
                        </tr>
                        <tr>
                            <th>Deed of Establishment (Akta)</th>
                            <td>
                                @if ($distributors->deed_of_establishment)
                                    <a href="{{ asset($distributors->deed_of_establishment) }}" target="_blank">Lihat Dokumen</a>
                                @else
                                    Tidak Ada Dokumen
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>NIB Document</th>
                            <td>
                                @if ($distributors->nib_document)
                                    <a href="{{ asset($distributors->nib_document) }}" target="_blank">Lihat Dokumen</a>
                                @else
                                    Tidak Ada Dokumen
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Verifikasi</th>
                            <td>
                                @if ($distributors->is_verified)
                                    <span class="badge bg-success">Terverifikasi</span>
                                @else
                                    <span class="badge bg-danger">Belum Terverifikasi</span>
                                    <!-- Tombol Verifikasi -->
                                    <form action="{{ route('distributors.verify', $distributors->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-warning">Verifikasi Akun</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        
                    </tbody>
                    
                </table>

                
                </div>
                </div>

            </div>
                <a href="{{ route('distributors.index') }}" class="btn btn-secondary">Kembali</a>
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
