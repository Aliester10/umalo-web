@extends('layouts.admin.master')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header">
            <h2 class="h4">Edit Pertanyaan</h2>
        </div>

        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.faq.update', $faq->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group mb-3">
                    <label for="questions">Pertanyaan</label>
                    <input type="text" class="form-control" id="questions" name="questions" value="{{ old('questions', $faq->questions) }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="answers">Jawaban</label>
                    <textarea class="form-control" id="answers" name="answers" rows="5" required>{{ old('answers', $faq->answers) }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Perbaharui Pertanyaan</button>
            </form>
        </div>
    </div>
</div>
@endsection
