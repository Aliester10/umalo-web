@extends('layouts.guest.master')

@section('content')
<!-- Header Start -->
<div class="container-fluid bg-breadcrumb" style="background: linear-gradient(rgb(7, 51, 7), rgba(0, 0, 0, 0.2)), url('{{ asset('assets/img/default_about.jpg') }}');     position: relative; overflow: hidden; background-position: center center; background-repeat: no-repeat; background-size: cover; padding: 60px 0; transition: 0.5s;">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">{{ __('messages.tutorial_video') }}</h4>
        <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('messages.home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('portal') }}">{{ __('messages.member_portal') }}</a></li>
            <li class="breadcrumb-item">{{ __('messages.tutorial_video') }}</li>
        </ol> 
    </div>
</div>
<!-- Header End -->

<div class="container-fluid team py-5">
    <div class="container py-5">
        <div class="section-title wow fadeInUp" data-wow-delay="0.1s"></div>
        <div class="container">
            <div class="row g-4 justify-content-center">
                @forelse($uniqueProduks as $produk)
                <div class="col-md-4 col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="service-img rounded-top shadow">
                            <img src="{{ asset($produk->images->first()->gambar ?? 'assets/img/default.jpg') }}" class="img-fluid rounded-top w-100" alt="{{ $produk->nama }}">
                            <div class="service-content-inner p-4" style="border-radius: 0 0 10px 10px;">
                                <h5>{{ $produk->nama }}</h5>
                                @forelse($produk->videos as $video)
                                    <div class="mb-3">
                                        <h6 class="mb-2">{{ __('messages.video') }} {{ $loop->iteration }}</h6>
                                        <div class="d-flex flex-wrap gap-2">
                                            <a href="{{ asset($video->video) }}" download="{{ $produk->nama }}_{{ $loop->iteration }}_tutorial.mp4" class="btn btn-primary rounded-pill text-white py-2 px-4 flex-fill">{{ __('messages.download') }}</a>
                                            <button class="btn btn-secondary rounded-pill text-white py-2 px-4 flex-fill" data-bs-toggle="modal" data-bs-target="#videoModal" data-video="{{ asset($video->video) }}">{{ __('messages.view') }}</button>
                                        </div>
                                    </div>
                                @empty
                                <p class="text-muted">{{ __('messages.no_videos_available') }}</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center">{{ __('messages.no_products_associated') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
        <div style="text-align: center;">
            <a class="btn btn-primary rounded-pill mt-5 mb-5 wow fadeInDown" data-wow-delay="0.5s" href="javascript:history.back()">{{ __('messages.back') }}</a>
        </div>
    </div>
</div>

<!-- Video Modal -->
<div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="videoModalLabel">Video Tutorial</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <video id="modalVideo" class="w-100" controls>
                    <source src="" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var videoModal = document.getElementById('videoModal');
        
        videoModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var videoSrc = button.getAttribute('data-video');
            var modalVideo = videoModal.querySelector('#modalVideo');
            var videoSource = modalVideo.querySelector('source');

            if (videoSrc) {
                videoSource.src = videoSrc;
                modalVideo.load();
            }
        });

        videoModal.addEventListener('hide.bs.modal', function () {
            var modalVideo = videoModal.querySelector('#modalVideo');
            modalVideo.pause();
            modalVideo.currentTime = 0;
        });
    });
</script>


@endsection

