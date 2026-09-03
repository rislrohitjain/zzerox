@extends('layouts.app')

@section('title', 'Authenticity | Zerox – Pharmaceuticals')

@section('content')
<!-- Authenticity Hero Banner -->
<section class="banner" style="position: relative;">
    <img src="{{ asset('img/authenticity-banner.png') }}" alt="Authenticity Banner" style="width: 100%; max-height: 380px; object-fit: cover;">
</section>

<!-- Verification Section matching Zerox.com -->
<section class="verification" style="padding: 60px 0; background: #fff;">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-7">
                <div class="verification__form" style="background: #f8f9fa; border: 1px solid #e2e8f0; border-radius: 8px; padding: 35px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                    <div class="verification__form-title" style="margin-bottom: 20px;">
                        <h2 style="font-size: 26px; font-weight: 700; color: #111; margin: 0; position: relative; padding-bottom: 10px; border-bottom: 2px solid #c9a227; display: inline-block;">
                            Product Verification
                        </h2>
                    </div>
                    <p style="color: #666; font-size: 14px; margin-bottom: 25px;">
                        Locate the metallic scratch-off security label on your Zerox product packaging and enter the code below to confirm authenticity.
                    </p>
                    <form action="{{ route('authenticity.verify') }}" method="post" id="verify-product-page" style="display: flex; gap: 10px; flex-wrap: wrap;">
                        @csrf
                        <input type="text" class="verification__form-field" name="security_code" autocomplete="off" placeholder="Enter code here" required style="flex-grow: 1; padding: 12px 18px; border: 1px solid #ccc; border-radius: 4px; font-size: 16px; font-weight: 600; text-transform: uppercase;">
                        <input type="submit" class="verification__form-check" value="Check" style="background: #c9a227; color: #000; font-weight: 700; font-size: 16px; padding: 12px 30px; border: none; border-radius: 4px; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#b89320';" onmouseout="this.style.background='#c9a227';">
                    </form>

                    <div id="page-verification-loader" class="verification__loader" style="display: none; margin-top: 20px;">
                        <div class="verification__loader-spinner"></div>
                        <span class="verification__loader-text">Verifying code against cryptographic database...</span>
                    </div>
                </div>

                <!-- Verification Guidance Box -->
                <div style="margin-top: 30px; background: #fff8e6; border: 1px solid #ffeeba; border-radius: 8px; padding: 25px;">
                    <h4 style="color: #856404; font-size: 16px; font-weight: 700; margin-top: 0; margin-bottom: 12px;">
                        <i class="bi bi-shield-check me-2"></i> Anti-Counterfeiting Security Guidelines
                    </h4>
                    <ul style="color: #856404; font-size: 13px; line-height: 1.6; margin: 0; padding-left: 20px;">
                        <li style="margin-bottom: 6px;"><strong>Genuine Products:</strong> Each valid security code can be authenticated. First-time checks output full batch credentials.</li>
                        <li style="margin-bottom: 6px;"><strong>Re-check Warning:</strong> If a code has been previously checked, the system outputs the initial check timestamp and IP log to prevent code copying.</li>
                        <li><strong>Invalid Code:</strong> If your scratch code is not recognized, refrain from consuming the product and contact <a href="mailto:support@zzerox.com" style="color: #856404; font-weight: 700;">support@zzerox.com</a>.</li>
                    </ul>
                </div>
            </div>

            <div class="col-xs-12 col-md-5" style="margin-top: 20px;">
                <div class="verification__image" style="text-align: center;">
                    <img src="{{ asset('img/product-verification.png') }}" alt="Product Verification" style="max-width: 100%; border-radius: 8px;">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Success Verification Modal Pop-up -->
<div id="page-verify-success" class="modal-custom">
    <div class="modal-custom-content">
        <span class="modal-custom-close" onclick="closePageModal('page-verify-success')">&times;</span>
        <div style="text-align: center;">
            <i class="bi bi-shield-check" style="font-size: 50px; color: #28a745;"></i>
            <h3 style="color: #28a745; margin-top: 10px; font-weight: 700;">AUTHENTIC PRODUCT CONFIRMED</h3>
            <p id="pageSuccessMessage" style="color: #333; margin: 15px 0; font-size: 15px;"></p>
            <div id="pageSuccessDetails" style="background: #f8f9fa; padding: 15px; border-radius: 6px; text-align: left; font-size: 14px; margin-bottom: 20px;"></div>
            <button onclick="closePageModal('page-verify-success')" style="background: #c9a227; color: #000; border: none; padding: 10px 25px; font-weight: 700; border-radius: 4px; cursor: pointer;">Close</button>
        </div>
    </div>
</div>

<!-- Previously Checked Verification Modal Pop-up -->
<div id="page-verify-checked" class="modal-custom">
    <div class="modal-custom-content">
        <span class="modal-custom-close" onclick="closePageModal('page-verify-checked')">&times;</span>
        <div style="text-align: center;">
            <i class="bi bi-exclamation-triangle" style="font-size: 50px; color: #ffc107;"></i>
            <h3 style="color: #d39e00; margin-top: 10px; font-weight: 700;">PREVIOUSLY VERIFIED CODE</h3>
            <p id="pageCheckedMessage" style="color: #333; margin: 15px 0; font-size: 15px;"></p>
            <button onclick="closePageModal('page-verify-checked')" style="background: #c9a227; color: #000; border: none; padding: 10px 25px; font-weight: 700; border-radius: 4px; cursor: pointer;">Close</button>
        </div>
    </div>
</div>

<!-- Error Verification Modal Pop-up -->
<div id="page-verify-error" class="modal-custom">
    <div class="modal-custom-content">
        <span class="modal-custom-close" onclick="closePageModal('page-verify-error')">&times;</span>
        <div style="text-align: center;">
            <i class="bi bi-x-circle" style="font-size: 50px; color: #dc3545;"></i>
            <h3 style="color: #dc3545; margin-top: 10px; font-weight: 700;">INVALID SECURITY CODE</h3>
            <p style="color: #333; margin: 15px 0; font-size: 15px;">The code you entered was not found in Zerox master verification database. Please check for typos or report to support.</p>
            <button onclick="closePageModal('page-verify-error')" style="background: #dc3545; color: #fff; border: none; padding: 10px 25px; font-weight: 700; border-radius: 4px; cursor: pointer;">Close</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("verify-product-page");
        const loader = document.getElementById("page-verification-loader");

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
                    form.style.display = "flex";

                    const data = res.body;

                    if (res.status === 200) {
                        if (data.status === "authentic") {
                            document.getElementById("pageSuccessMessage").innerText = data.message;
                            let detailsHtml = `<strong>Security Code:</strong> ${data.code}<br>
                                               <strong>Batch Number:</strong> ${data.batch_number}<br>
                                               <strong>Verified On:</strong> ${data.verified_at}`;
                            if (data.product) {
                                detailsHtml += `<br><strong>Product:</strong> <a href="${data.product.url}" style="color: #c9a227; font-weight: bold;">${data.product.name}</a> (${data.product.dosage_form})`;
                            }
                            document.getElementById("pageSuccessDetails").innerHTML = detailsHtml;
                            showPageModal("page-verify-success");
                        } else if (data.status === "previously_verified") {
                            document.getElementById("pageCheckedMessage").innerHTML = data.message;
                            showPageModal("page-verify-checked");
                        }
                    } else {
                        showPageModal("page-verify-error");
                    }
                })
                .catch(error => {
                    loader.style.display = "none";
                    form.style.display = "flex";
                    showPageModal("page-verify-error");
                });
            });
        }
    });

    function showPageModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.style.display = "block";
        }
    }

    function closePageModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.style.display = "none";
        }
    }
</script>
@endsection
