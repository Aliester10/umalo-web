@extends('layouts.guest.master')

@section('content')
           <!-- Header Start -->
           <div class="container-fluid bg-breadcrumb" style="background: linear-gradient(rgb(7, 51, 7), rgba(0, 0, 0, 0.2)), url('{{ asset('assets/img/about_banner.jpg') }}'); position: relative; overflow: hidden; background-position: center center; background-repeat: no-repeat; background-size: cover; padding: 20px 0; transition: 0.5s;">
            <div class="container text-center py-3" style="max-width: 900px;">
                <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">{{ __('messages.contact') }}</h4>
                <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('messages.home') }}</a></li>
                    <li class="breadcrumb-item  text-white">{{ __('messages.contact') }}</li>
                </ol>
            </div>
        </div>
        <!-- Header End -->

        <!-- Contact Start -->
        <div class="container-fluid contact bg-light py-5">
            <div class="container py-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                    <h4 class="text-primary">{{ __('messages.contact') }}</h4>
                    <h1 class="display-4 mb-4">{{ __('messages.comments_apply') }}</h1>
                </div>
                <div class="row g-5">
                    <div class="col-xl-6 wow fadeInLeft" data-wow-delay="0.2s">
                        <div class="contact-img d-flex justify-content-center">
                            <div class="contact-img-inner">
                                <img src="{{ asset($compayny->logo ?? 'assets/img/logo.png') }}" class="img-fluid" alt="Image">
                            </div>
                        </div>
                    </div>

                    <style>
                        .contact-img {
                        position: relative;
                        height: 100%; /* Ensure the parent has a set height */
                    }

                    .contact-img-inner {
                        position: absolute;
                        top: 80%; /* Center vertically */
                        left: 50%; /* Center horizontally */
                        transform: translate(-50%, -50%); /* Adjust to center the element properly */
                        max-width: 100%; /* Optional: Limit the size of the logo to fit within the container */
                    }

                    /* Adjustments for mobile screens */
                    @media (max-width: 768px) {
                        .contact-img-inner {
                            top: 50%; /* More central vertical positioning on mobile */
                            max-width: 100%; /* Optionally adjust the max width for smaller screens */
                            
                        }
                    }
                    </style>

                    <div class="col-xl-6 wow fadeInRight" data-wow-delay="0.4s">
                        <div>
                            <h4 class="text-primary">{{ __('messages.send_message_title') }}</h4>
                            <p class="mb-4">{{ __('messages.send_message_description') }}</p>
                            
                            <form method="POST" action="{{ route('contact.store') }}">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-lg-12 col-xl-6">
                                        <div class="form-floating">
                                            <input type="text" name="name" class="form-control border-0" id="name" placeholder="{{ __('messages.contact_form.your_name') }}" required>
                                            <label for="name">{{ __('messages.contact_form.your_name') }} <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-xl-6">
                                        <div class="form-floating">
                                            <input type="email" name="email" class="form-control border-0" id="email" placeholder="{{ __('messages.contact_form.your_email') }}" required>
                                            <label for="email">{{ __('messages.contact_form.your_email') }} <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-xl-6">
                                        <div class="form-floating">
                                            <input type="text" name="phone" class="form-control border-0" id="phone" placeholder="{{ __('messages.contact_form.your_phone') }}"
                                                pattern="[0-9]{8,15}" title="Please enter a valid phone number (8-15 digits)" inputmode="numeric"
                                                minlength="8" maxlength="15" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                            <label for="phone">{{ __('messages.contact_form.your_phone') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-xl-6">
                                        <div class="form-floating">
                                            <input type="text" name="company" class="form-control border-0" id="project" placeholder="{{ __('messages.contact_form.your_company') }}">
                                            <label for="project">{{ __('messages.contact_form.your_company') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" name="subject" class="form-control border-0" id="subject" placeholder="{{ __('messages.contact_form.subject') }}" required>
                                            <label for="subject">{{ __('messages.contact_form.subject') }} <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea class="form-control border-0" name="message" placeholder="{{ __('messages.contact_form.message') }}" id="message" style="height: 120px" required></textarea>
                                            <label for="message">{{ __('messages.contact_form.message') }} <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100 py-3">{{ __('messages.contact_form.send_message') }}</button>
                                    </div>
                                </div>
                            </form>
                            
                            
                            
                        </div>
                    </div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-3 bg-white p-3 rounded wow fadeInUp mx-2 mt-2" data-wow-delay="0.2s">
                                <div class="contact-add-item">
                                    <div class="contact-icon text-primary mb-4">
                                        <i class="fas fa-map-marker-alt fa-2x"></i>
                                    </div>
                                    <div>
                                        <h4>{{ __('messages.contact_info.address') }}</h4>
                                        <p class="mb-0">{{ $company->address }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 bg-white p-3 rounded wow fadeInUp mx-2 mt-2" data-wow-delay="0.4s">
                                <div class="contact-add-item">
                                    <div class="contact-icon text-primary mb-4">
                                        <i class="fas fa-envelope fa-2x"></i>
                                    </div>
                                    <div>
                                        <h4>{{ __('messages.contact_info.mail_us') }}</h4>
                                        <p class="mb-0">{{ $company->email }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 bg-white p-3 rounded wow fadeInUp mx-2 mt-2" data-wow-delay="0.6s">
                                <div class="contact-add-item">
                                    <div class="contact-icon text-primary mb-4">
                                        <i class="fa fa-phone-alt fa-2x"></i>
                                    </div>
                                    <div>
                                        <h4>{{ __('messages.contact_info.telephone') }}</h4>
                                        <p class="mb-0">{{ $company->no_wa }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    
                    <div class="col-12 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="rounded">
                            <iframe class="rounded w-100" 
                            style="height: 400px;" src="{{ $company->maps_iframe }}" 
                            loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contact End -->
       



        <!-- Error Modal -->
@if($errors->any())
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border: 2px solid #dc3545;">
            <div class="modal-header" style="background-color: #dc3545; color: #fff;">
                <h5 class="modal-title" id="errorModalLabel">Error</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
            </div>
            <div class="modal-body" style="background-color: #f8d7da; color: #721c24;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Success Modal -->
@if(session('success'))
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border: 2px solid #107C10;">
            <div class="modal-header" style="color: #107C10; ">
                <h5 class="modal-title" id="successModalLabel"><b>Success</b></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
            </div>
            <div class="modal-body" style="background-color: #d4edda; color: #155724;">
                {{ session('success') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endif


<script>
    document.addEventListener("DOMContentLoaded", function() {
        @if($errors->any())
            var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            errorModal.show();
        @endif
    
        @if(session('success'))
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        @endif
    });
    </script>


@endsection
