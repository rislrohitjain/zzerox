@extends('layouts.app')

@section('title', 'Home | Zerox – Pharmaceuticals')

@section('content')

<!-- Dynamic Hero Banner Section (Backend Managed Banners) -->
<section class="banner">
    @if(isset($banners) && count($banners) > 0)
        @foreach($banners as $index => $banner)
            <div class="banner-item {{ $loop->first ? 'active' : '' }}" style="position: relative;">
                <img src="{{ asset($banner->image_path) }}" alt="{{ $banner->title }}" style="width: 100%; max-height: 480px; object-fit: cover;">
                @if($banner->subtitle || $banner->button_text)
                    <div style="position: absolute; bottom: 30px; left: 10%; background: rgba(0,0,0,0.65); padding: 20px 30px; border-radius: 8px; color: #fff; max-width: 600px;">
                        <h2 style="font-size: 22px; margin-bottom: 10px; color: #c9a227; font-weight: 700;">{{ $banner->subtitle }}</h2>
                        @if($banner->button_text)
                            <a href="{{ $banner->button_url ?? '/category/tablets' }}" style="display: inline-block; background: #c9a227; color: #000; padding: 8px 22px; font-weight: 700; border-radius: 4px; text-decoration: none;">{{ $banner->button_text }}</a>
                        @endif
                    </div>
                @endif
            </div>
            @break
        @endforeach
    @else
        <img src="{{ asset('img/home-banner.png') }}" alt="Home banner">
    @endif
</section>

<!-- Product Verification Section matching Zerox.com -->
<section class="verification">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-7">
                <div class="verification__form">
                    <div class="verification__form-title">
                        <span class="verification__form-title__text">
                            Product Verification
                        </span>
                    </div>
                    <form action="{{ route('authenticity.verify') }}" method="post" id="verify-product">
                        @csrf
                        <input type="text" class="verification__form-field" name="security_code" autocomplete="off" placeholder="Enter code here" required>
                        <input type="submit" class="verification__form-check" value="Check">
                    </form>

                    <div id="verification-loader" class="verification__loader" style="display: none;">
                        <div class="verification__loader-spinner"></div>
                        <span class="verification__loader-text">Verifying code against cryptographic database...</span>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-5">
                <div class="verification__image">
                    <img src="{{ asset('img/product-verification.png') }}" alt="Product Verification">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Welcome Section ("Behind The Science") -->
<section class="welcome">
    <img class="welcome__before" src="{{ asset('img/white-figure.png') }}" alt="">
    <div class="container">
        <div class="row">
            <div class="col-md-7 col-xs-12">
                <h2 class="welcome__title"><span class="welcome__title__text">Welcome</span></h2>
                <h3 class="welcome__subtitle">Behind The Science</h3>
                <div class="welcome__description">
                    <p>
                        The pharmaceutical company Zerox Pharmaceuticals Ltd works for the benefit of citizens of
                        India and around the world, improving the quality of life of people with various diseases.
                        Even today, our drugs help millions of people to get rid of ailments and feel the fullness
                        of life.
                    </p>
                    <p>
                        The pharmaceutical company Zerox is one of the leaders of the Indian pharmaceutical market
                        for production of anabolic steroids. GMP (Good Manufacturing Practice) standards allow the
                        company to produce high quality products available to wider layers of population.
                    </p>
                </div>
            </div>
            <div class="col-md-5 col-xs-12">
                <div class="welcome__image">
                    <img src="{{ asset('img/welcome-image.png') }}" alt="Welcome">
                </div>
            </div>
        </div>
        <div class="welcome__read-more">
            <a href="{{ route('about') }}">About Us</a>
        </div>
    </div>
</section>

<!-- Quote / Mission Section -->
<section class="zerox">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-xs-12 col-md-offset-6">
                <h2 class="zerox__title">
                    <span class="zerox__title-text">
                        "Working together for a healthier world.<br>
                        Zerox. Life is our life's work."
                    </span>
                </h2>
                <p class="zerox__description">
                    We like to be industry leaders and role models in an ever-changing
                    environment. We are enthusiastically the first to offer new drugs to the
                    market and realize the opening opportunities. We believe that
                    leadership is provided by people and their efforts.
                </p>
                <a href="{{ route('category.show', 'tablets') }}" class="zerox__btn">See our products</a>
            </div>
        </div>
    </div>
    <img class="zerox__before" src="{{ asset('img/services-before-bg.png') }}" alt="">
</section>

<!-- Product Category Icons Section -->
<section class="services">
    <div class="services__content">
        <div class="container">
            <div class="row">
                <div class="col-md-2 col-sm-2 col-xs-12">
                    <a href="{{ route('category.show', 'tablets') }}" class="services__item">
                        <span class="services__icon services__icon_tablets"></span>
                        <span class="services__title">Tablets</span>
                    </a>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-12">
                    <a href="{{ route('category.show', 'injectables-1-ml') }}" class="services__item">
                        <span class="services__icon services__icon_injectables"></span>
                        <span class="services__title">Injectables 1 ml</span>
                    </a>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-12">
                    <a href="{{ route('category.show', 'hgh') }}" class="services__item">
                        <span class="services__icon services__icon_hgh"></span>
                        <span class="services__title">HGH</span>
                    </a>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-12">
                    <a href="{{ route('category.show', 'peptides') }}" class="services__item">
                        <span class="services__icon services__icon_peptides"></span>
                        <span class="services__title">Peptides</span>
                    </a>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-12">
                    <a href="{{ route('category.show', 'injectables-10-ml') }}" class="services__item">
                        <span class="services__icon services__icon_injectables_ten"></span>
                        <span class="services__title">Injectables 10 ml</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <img class="services__after" src="{{ asset('img/services-after-bg.png') }}" alt="">
</section>

<!-- Success Verification Modal Pop-up -->
<div id="verify-product-success" class="modal-custom">
    <div class="modal-custom-content">
        <span class="modal-custom-close" onclick="closeModal('verify-product-success')">&times;</span>
        <div style="text-align: center;">
            <i class="bi bi-shield-check" style="font-size: 50px; color: #28a745;"></i>
            <h3 style="color: #28a745; margin-top: 10px; font-weight: 700;">AUTHENTIC PRODUCT CONFIRMED</h3>
            <p id="successModalMessage" style="color: #333; margin: 15px 0; font-size: 15px;"></p>
            <div id="successModalDetails" style="background: #f8f9fa; padding: 15px; border-radius: 6px; text-align: left; font-size: 14px; margin-bottom: 20px;"></div>
            <button onclick="closeModal('verify-product-success')" style="background: #c9a227; color: #000; border: none; padding: 10px 25px; font-weight: 700; border-radius: 4px; cursor: pointer;">Close</button>
        </div>
    </div>
</div>

<!-- Previously Checked Verification Modal Pop-up -->
<div id="verify-product-checked" class="modal-custom">
    <div class="modal-custom-content">
        <span class="modal-custom-close" onclick="closeModal('verify-product-checked')">&times;</span>
        <div style="text-align: center;">
            <i class="bi bi-exclamation-triangle" style="font-size: 50px; color: #ffc107;"></i>
            <h3 style="color: #d39e00; margin-top: 10px; font-weight: 700;">PREVIOUSLY VERIFIED CODE</h3>
            <p class="checked-date" style="color: #333; margin: 15px 0; font-size: 15px;"></p>
            <button onclick="closeModal('verify-product-checked')" style="background: #c9a227; color: #000; border: none; padding: 10px 25px; font-weight: 700; border-radius: 4px; cursor: pointer;">Close</button>
        </div>
    </div>
</div>

<!-- Error Verification Modal Pop-up -->
<div id="verify-product-error" class="modal-custom">
    <div class="modal-custom-content">
        <span class="modal-custom-close" onclick="closeModal('verify-product-error')">&times;</span>
        <div style="text-align: center;">
            <i class="bi bi-x-circle" style="font-size: 50px; color: #dc3545;"></i>
            <h3 style="color: #dc3545; margin-top: 10px; font-weight: 700;">INVALID SECURITY CODE</h3>
            <p style="color: #333; margin: 15px 0; font-size: 15px;">The code you entered was not found in Zerox master verification database. Please check for typos or report to support.</p>
            <button onclick="closeModal('verify-product-error')" style="background: #dc3545; color: #fff; border: none; padding: 10px 25px; font-weight: 700; border-radius: 4px; cursor: pointer;">Close</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("verify-product");
        const loader = document.getElementById("verification-loader");

        if (form) {
            form.addEventListener("submit", function (e) {
                e.preventDefault();

                form.style.display = "none";
                loader.style.display = "flex";

                const formData = new FormData(form);
                const actionUrl = form.getAttribute("action");

                fetch(actionUrl, {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-Requested-With": "XMLHttpRequest"
                    }
                })
                .then(response => response.json().then(data => ({ status: response.status, body: data })))
                .then(res => {
                    loader.style.display = "none";
                    form.style.display = "block";

                    const data = res.body;

                    if (res.status === 200) {
                        if (data.status === "authentic") {
                            document.getElementById("successModalMessage").innerText = data.message;
                            let detailsHtml = `<strong>Security Code:</strong> ${data.code}<br>
                                               <strong>Batch Number:</strong> ${data.batch_number}<br>
                                               <strong>Verified On:</strong> ${data.verified_at}`;
                            if (data.product) {
                                detailsHtml += `<br><strong>Product:</strong> <a href="${data.product.url}" style="color: #c9a227; font-weight: bold;">${data.product.name}</a> (${data.product.dosage_form})`;
                            }
                            document.getElementById("successModalDetails").innerHTML = detailsHtml;
                            showModal("verify-product-success");
                        } else if (data.status === "previously_verified") {
                            const modal = document.getElementById("verify-product-checked");
                            if (modal) {
                                modal.querySelector(".checked-date").innerHTML = data.message;
                            }
                            showModal("verify-product-checked");
                        }
                    } else {
                        showModal("verify-product-error");
                    }
                })
                .catch(error => {
                    loader.style.display = "none";
                    form.style.display = "block";
                    showModal("verify-product-error");
                });
            });
        }
    });

    function showModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.style.display = "block";
        }
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.style.display = "none";
        }
    }
</script>
@endsection
