@extends('layouts.member.master')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header ">
            <h2 class="h4 mb-0">Dokumentasi untuk Produk: {{ $usersProduct->product->name }}</h2>
        </div>
        <div class="card-body">
            @if($usersProduct->documentations->isEmpty())
                <div class="alert alert-warning">
                    Belum ada dokumentasi untuk produk ini.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Status</th>
                                <th>Tanggal Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usersProduct->documentations as $index => $documentation)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $documentation->status }}</td>
                                    <td>{{ $documentation->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <a href="{{ route('member.documentation.show', $documentation->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('member.products.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
