@extends('layouts.guest.master')

@section('content')
               <!-- Header Start -->
               <div class="container-fluid bg-breadcrumb" style="background: linear-gradient(rgb(7, 51, 7), rgba(0, 0, 0, 0.2)), url('{{ asset('assets/img/aktivitis perusahaan.jpg') }}');     position: relative; overflow: hidden; background-position: center center; background-repeat: no-repeat; background-size: cover; padding: 20px 0; transition: 0.5s;">
                <div class="container text-center py-3" style="max-width: 900px;">
                    <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">{{ __('messages.company_activity') }}</h4>
                    <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('messages.home') }}</a></li>
                        <li class="breadcrumb-item active text-white">{{ __('messages.activity') }}</li>
                    </ol>
                </div>
            </div>
            <!-- Header End -->

    <!-- Activity Start -->
    <div class="container-fluid blog py-5">
        @if($activities->isEmpty())
        <div class="col-12 text-center mt-5 mb-5">
            <h1 class="text-muted">{{ __('messages.no_activity') }}</h1>
        </div>
    @else
        <div class="container py-5">
            <!-- Navigation Section -->
            <div class="row mb-4">
                <!-- Showing X-Y of Z -->
                <div class="col-md-4 d-flex align-items-center">
                    <p class="mb-0">Menampilkan {{ $activities->firstItem() }} - {{ $activities->lastItem() }} dari
                        {{ $activities->total() }}</p>
                </div>
                <!-- Show per Page and Sort By -->
                <div class="col-md-8 d-flex justify-content-end align-items-center">
                    <div class="d-flex align-items-center">
                        <label for="sort-by" class="mb-0 me-4" style="display: inline-block; white-space: nowrap;">
                            {{ __('messages.sort_by') }} :
                        </label>
                        <select id="sort-by" class="form-select form-select-sm">
                            <option value="newest" {{ $sort == 'newest' ? 'selected' : '' }}>{{ __('messages.newest') }}</option>
                            <option value="latest" {{ $sort == 'latest' ? 'selected' : '' }}>{{ __('messages.latest') }}</option>
                        </select>
                    </div>
                </div>


                <script>
                    document.getElementById('sort-by').addEventListener('change', function() {
                        var sort = this.value;
                        window.location.href = '?sort=' + sort;
                    });
                </script>

            </div>

            <!-- Activity Content -->
            <div class="row g-4 justify-content-center">
                    @foreach ($activities as $item)
                        <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="blog-item rounded">
                                <div class="blog-img">
                                    <img src="{{ asset($item->images) }}" class="img-fluid w-100" alt="Image"
                                         style="border-radius: 15px; width: 100%; height: 250px; object-fit: cover;">
                                </div>
                                <div class="blog-content p-4" style="flex-grow: 1;">
                                    <div class="d-flex justify-content-between mb-4">
                                        <p class="mb-0 text-muted" style="font-size: 0.875rem;">
                                            <i class="fa fa-calendar-alt text-primary"></i> {{ $item->date->format('d M Y') }}
                                        </p>
                                    </div>
                                    <a href="#" class="h4" style="font-weight: bold; color: #343a40; text-decoration: none;">
                                        {{ $item->title }}
                                    </a>
                                    <p class="my-4" style="font-size: 0.875rem; color: #6c757d; margin: 0; line-height: 1.5; overflow: hidden; white-space: normal; word-wrap: break-word;">
                                        {{ Str::limit($item->description, 60) }}
                                    </p>
                                    <a href="{{ route('activity.show', $item->id) }}" class="btn btn-primary rounded-pill text-white py-2 px-4 mb-1">
                                        {{ __('messages.more_detail') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
            </div>



            <!-- Pagination -->
            <div class="row mt-4">
                <div class="col-12">
                    {{ $activities->links() }} <!-- Menampilkan pagination -->
                </div>
            </div>
        </div>
        @endif

    </div>
    <!-- Activity End -->
@endsection
