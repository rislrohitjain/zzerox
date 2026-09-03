@extends('layouts.app')

@section('title', 'Product Verification - Zerox Security Scratch-Code Authenticator')

@section('content')
<div class="bg-dark text-white py-5 mb-5" style="background: linear-gradient(135deg, #091528, #0f2342);">
    <div class="container text-center py-4">
        <span class="badge bg-info text-dark font-monospace fw-bold mb-2 px-3 py-2 text-uppercase"><i class="bi bi-shield-lock-fill me-1"></i> Anti-Counterfeiting Portal</span>
        <h1 class="display-5 fw-bold mb-2">Scratch Security Code Authenticator</h1>
        <p class="lead text-info max-w-2xl mx-auto">Verify your Zerox Pharmaceuticals product batch instantly to protect against counterfeit imitations.</p>
    </div>
</div>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card card-zx border-0 shadow-lg p-4 p-md-5 bg-white">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="p-3 bg-info bg-opacity-10 text-info rounded-circle d-inline-block mb-3">
                            <i class="bi bi-qr-code-scan display-4"></i>
                        </div>
                        <h3 class="fw-bold text-dark">Enter Security Scratch Code</h3>
                        <p class="text-muted small">Locate the scratch-off metallic security label on your Zerox product packaging box and enter the unique code below.</p>
                    </div>

                    <form action="{{ route('authenticity.verify') }}" method="POST" id="mainVerifyForm">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label font-monospace fw-bold text-uppercase text-secondary">Security Scratch Code</label>
                            <input type="text" name="security_code" id="securityCodeInput" class="form-control form-control-lg text-center font-monospace fw-bold border-2 border-info shadow-none" placeholder="e.g. ZX-8829-AB41" required autocomplete="off" style="font-size: 1.5rem; letter-spacing: 2px;">
                            <div class="form-text text-center text-muted">Format: ZX-XXXX-XXXX or alphanumeric string</div>
                        </div>

                        <button type="submit" class="btn btn-auth-check btn-lg w-100 py-3 text-uppercase fw-bold" style="font-size: 1.1rem;">
                            <i class="bi bi-shield-check me-2"></i> Verify Product Authenticity
                        </button>
                    </form>

                    <!-- Interactive Response Feedback Container -->
                    <div id="verifyResultContainer" class="mt-4" style="display: none;"></div>

                    <!-- Instructions -->
                    <div class="mt-5 p-4 bg-light rounded border">
                        <h6 class="fw-bold text-dark mb-3"><i class="bi bi-info-circle text-info me-2"></i> How Security Verification Works:</h6>
                        <ul class="small text-secondary mb-0 ps-3">
                            <li class="mb-2"><strong>Authentic Code:</strong> First-time entry will confirm batch authenticity, product formulation details, and manufacturing date.</li>
                            <li class="mb-2"><strong>Previously Verified:</strong> If a code has been checked prior to your request, the system displays the timestamp and IP address of initial verification to prevent reused scratch labels.</li>
                            <li><strong>Invalid Code Warning:</strong> If the code does not exist in our master database, refrain from consuming the product and report it to <a href="mailto:support@zzerox.com" class="text-info fw-bold">support@zzerox.com</a>.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('mainVerifyForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const resultContainer = document.getElementById('verifyResultContainer');
        resultContainer.style.display = 'block';
        resultContainer.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-info" role="status"></div><p class="text-muted mt-2">Querying master cryptographic registry...</p></div>';

        const formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json().then(data => ({ status: response.status, body: data })))
        .then(res => {
            const data = res.body;
            let html = '';

            if (res.status === 200) {
                if (data.status === 'authentic') {
                    html = `
                    <div class="alert alert-success border-2 border-success p-4 rounded-3 text-start shadow-sm">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <i class="bi bi-check-circle-fill text-success display-5"></i>
                            <div>
                                <h4 class="fw-bold text-success m-0">100% AUTHENTIC PRODUCT CONFIRMED</h4>
                                <small class="text-muted">Verified on ${data.verified_at}</small>
                            </div>
                        </div>
                        <hr>
                        <div class="row g-2 small">
                            <div class="col-sm-6"><strong>Security Code:</strong> <span class="font-monospace text-dark">${data.code}</span></div>
                            <div class="col-sm-6"><strong>Batch Number:</strong> <span class="font-monospace text-dark">${data.batch_number}</span></div>
                            ${data.product ? `
                                <div class="col-sm-6"><strong>Product Name:</strong> ${data.product.name}</div>
                                <div class="col-sm-6"><strong>Category:</strong> ${data.product.category}</div>
                                <div class="col-12 mt-2">
                                    <a href="${data.product.url}" class="btn btn-sm btn-success fw-bold me-2"><i class="bi bi-box-arrow-up-right me-1"></i> View Formulation Details</a>
                                </div>
                            ` : ''}
                        </div>
                    </div>`;
                } else if (data.status === 'previously_verified') {
                    html = `
                    <div class="alert alert-warning border-2 border-warning p-4 rounded-3 text-start shadow-sm">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <i class="bi bi-exclamation-triangle-fill text-warning display-5"></i>
                            <div>
                                <h4 class="fw-bold text-dark m-0">PREVIOUSLY VERIFIED CODE</h4>
                                <small class="text-dark">${data.message}</small>
                            </div>
                        </div>
                        <hr>
                        <div class="row g-2 small text-dark">
                            <div class="col-sm-6"><strong>Security Code:</strong> <span class="font-monospace">${data.code}</span></div>
                            <div class="col-sm-6"><strong>Batch Number:</strong> <span class="font-monospace">${data.batch_number}</span></div>
                        </div>
                    </div>`;
                }
            } else {
                html = `
                <div class="alert alert-danger border-2 border-danger p-4 rounded-3 text-start shadow-sm">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <i class="bi bi-x-circle-fill text-danger display-5"></i>
                        <div>
                            <h4 class="fw-bold text-danger m-0">INVALID CODE - COUNTERFEIT WARNING</h4>
                            <small class="text-dark">The code <strong>"${data.code || ''}"</strong> was not found in Zerox master verification database.</small>
                        </div>
                    </div>
                    <p class="small text-danger mb-0">Please check your typing or contact customer support immediately if you suspect counterfeit packaging.</p>
                </div>`;
            }

            resultContainer.innerHTML = html;
        })
        .catch(err => {
            resultContainer.innerHTML = '<div class="alert alert-danger p-3">Server connection error. Please try again.</div>';
        });
    });
</script>
@endsection
