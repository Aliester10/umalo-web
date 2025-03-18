@extends('layouts.admin.master')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg">
                <div class="card-header bg-dark text-white d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Pesan dari "{{ $message->name }}"</h4>
                    <span class="badge bg-light text-primary">{{ $message->created_at->format('d M, Y H:i') }}</span>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h5 class="text-muted"><strong>Informasi Kontak</strong></h5>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>Email</th>
                                    <td><a href="mailto:{{ $message->email }}" class="text-decoration-none">{{ $message->email }}</a></td>
                                </tr>
                                @if($message->phone)
                                <tr>
                                    <th>Telepon</th>
                                    <td><a href="tel:{{ $message->phone }}" class="text-decoration-none">{{ $message->phone }}</a></td>
                                </tr>
                                @endif
                                @if($message->company)
                                <tr>
                                    <th>Perusahaan</th>
                                    <td>{{ $message->company }}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                
                    <div class="mb-3">
                        <h5 class="text-muted"><strong>Detail Pesan</strong></h5>
                        <div class="mb-2">
                            <strong>Subjek:</strong> 
                            <p>{{ $message->subject }}</p>
                        </div>
                        <div class="mb-2">
                            <strong>Pesan:</strong>
                            <div class="bg-light p-3 rounded border">
                                {{ $message->message }}
                            </div>
                        </div>
                    </div>
                    
                </div>
                
                <div class="card-footer text-end">
                    <a href="{{ route('messages.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Pesan
                    </a>
                    <form action="{{ route('messages.destroy', $message->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this message?');">
                            <i class="fas fa-trash-alt"></i> Hapus Pesan
                        </button>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
@endsection
