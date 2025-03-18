@extends('layouts.app')

@section('content')
    <h1>{{ $meta->title }}</h1>

    <p>Tanggal Mulai : {{ $meta->start_date }}</p>
    <p>Tanggal Berakhir : {{ $meta->end_date }}</p>

    <div>
        {!! $meta->content !!}
    </div>
@endsection
