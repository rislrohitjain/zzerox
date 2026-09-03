@extends('layouts.app')

@section('title', 'Contact Us - Zerox Pharmaceuticals Ltd')

@section('content')
<div class="bg-dark text-white py-5 mb-5" style="background: linear-gradient(135deg, #091528, #0f2342);">
    <div class="container text-center py-4">
        <h1 class="display-5 fw-bold mb-2">Global Inquiries & Support</h1>
        <p class="lead text-info max-w-2xl mx-auto">Get in touch with Zerox Pharmaceuticals corporate team, official distributors, or technical support.</p>
    </div>
</div>

<div class="container pb-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-5">
        <div class="col-lg-7">
            <div class="card card-zx border-0 shadow-sm p-4">
                <div class="card-body">
                    <h3 class="fw-bold mb-4">Send Us a Message</h3>
                    <form action="{{ route('contact.submit') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Your Full Name</label>
                                <input type="text" name="name" class="form-control form-control-lg" placeholder="John Doe" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Email Address</label>
                                <input type="email" name="email" class="form-control form-control-lg" placeholder="name@domain.com" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label font-weight-bold">Subject</label>
                                <input type="text" name="subject" class="form-control form-control-lg" placeholder="Distribution inquiry / Product batch query" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label font-weight-bold">Message</label>
                                <textarea name="message" rows="5" class="form-control" placeholder="Write your message details here..." required></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-auth-check btn-lg w-100">
                                    <i class="bi bi-send-fill me-2"></i> Submit Inquiry
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card card-zx bg-dark text-white p-4 h-100 border-0">
                <div class="card-body d-flex flex-column">
                    <h4 class="text-info fw-bold mb-4"><i class="bi bi-building me-2"></i> Corporate Headquarters</h4>

                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="p-3 bg-info bg-opacity-10 text-info rounded">
                            <i class="bi bi-geo-alt-fill fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold m-0 text-white">Office & Manufacturing Facility</h6>
                            <p class="small text-secondary m-0">{{ \App\Models\SiteSetting::get('company_address', 'Plot No. 42, Industrial Area Phase II, New Delhi, India - 110020') }}</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="p-3 bg-info bg-opacity-10 text-info rounded">
                            <i class="bi bi-telephone-fill fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold m-0 text-white">Telephone Hotline</h6>
                            <p class="small text-secondary m-0">{{ \App\Models\SiteSetting::get('contact_phone', '+91 11 27023256') }}</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="p-3 bg-info bg-opacity-10 text-info rounded">
                            <i class="bi bi-envelope-fill fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold m-0 text-white">Official Support Email</h6>
                            <p class="small text-secondary m-0">{{ \App\Models\SiteSetting::get('contact_email', 'support@zzerox.com') }}</p>
                        </div>
                    </div>

                    <!-- Google Maps Embed Placeholder -->
                    <div class="mt-auto rounded overflow-hidden border border-secondary" style="height: 180px; background: #1e293b;">
                        <iframe width="100%" height="100%" frameborder="0" style="border:0;" src="https://maps.google.com/maps?q=New%20Delhi%20Industrial%20Area&t=&z=13&ie=UTF8&iwloc=&output=embed"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
