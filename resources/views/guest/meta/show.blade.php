@extends('layouts.guest.master')

@section('content')
                   <!-- Header Start -->
                   <div class="container-fluid bg-breadcrumb" style="background: linear-gradient(rgb(7, 51, 7), rgba(0, 0, 0, 0.2)), url('{{ asset('assets/img/default_about.jpg') }}');     position: relative; overflow: hidden; background-position: center center; background-repeat: no-repeat; background-size: cover; padding: 60px 0; transition: 0.5s;">
                    <div class="container text-center py-5" style="max-width: 900px;">
                        <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">{{ ucfirst($meta->type) }}</h4>
                        <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item">{{ ucfirst($meta->type) }}</li>
                            <li class="breadcrumb-item active text-primary">{{ ucfirst($meta->title) }}</li>            
                        </ol>    
                    </div>
                </div>
                <!-- Header End -->

    <!-- Meta Content Section Start -->
    <div class="container mt-5 mb-5 py-5">
        <!-- Meta Title -->
        <h1 class="mb-4 text-center display-4">{{ $meta->title }}</h1>
    
        <!-- Card for Meta Content -->
        <div class="card border-0 shadow-lg rounded-3">
            <div class="card-body p-5">
                <div class="content-wrapper">
                    <!-- Meta Content -->
                    {!! $meta->content !!}
                </div>
                <!-- Display the creation date -->
                <p class="text-muted mt-4 text-end">
                    <em>{{ $meta->created_at->format('d F Y') }}</em>
                </p>
            </div>
        </div>
    </div>
    
    <!-- Meta Content Section End -->

@endsection

@section('styles')
    <!-- Custom Styles for Meta Page -->
    <style>
        .card {
            border-radius: 0.5rem;
        }

        .content-wrapper {
            padding: 1.5rem;
            border: 1px solid #e2e6ea;
            border-radius: 0.5rem;
            background-color: #f8f9fa;
        }

        h1 {
            font-size: 2rem;
            font-weight: 600;
        }

        .card-body {
            padding: 2rem;
        }

        .breadcrumb-item a {
            color: white;
            text-decoration: underline;
        }

        .breadcrumb-item.active {
            color: #f8c146;
        }

        @media (max-width: 767.98px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }
    </style>
@endsection
