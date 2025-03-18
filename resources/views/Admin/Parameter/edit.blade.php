@extends('layouts.admin.master')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header">
            <h2 class="h4">Edit Parameter Perusahaan</h2>
        </div>

        <div class="card-body">
            <form action="{{ route('parameter.update', $companyParameter->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @include('admin.parameter.partials.form')

                <button type="submit" class="btn btn-primary">Perbaharui</button>
            </form>
        </div>
    </div>
</div>
@endsection
