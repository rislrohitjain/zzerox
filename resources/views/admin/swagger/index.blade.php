@extends('layouts.admin')

@section('title', 'API Documentation & Swagger UI - Zerox Admin')
@section('page_title', 'REST API Explorer & Swagger UI Documentation')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/5.11.0/swagger-ui.min.css" />
<style>
    #swagger-ui {
        background: #ffffff;
        border-radius: 8px;
        padding: 20px;
    }
    .swagger-ui .topbar { display: none; }
</style>
@endsection

@section('content')
<!-- API Quick Info Card -->
<div class="card border-0 shadow-sm bg-white p-4 mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h5 class="fw-bold text-dark m-0"><i class="bi bi-code-slash text-primary me-2"></i> RESTful API Documentation & Interactive Swagger UI</h5>
            <small class="text-muted">Explore and test Zerox Pharmaceuticals REST API endpoints live directly from your admin panel.</small>
        </div>
        <div>
            <a href="{{ url('/api/v1/openapi.json') }}" target="_blank" class="btn btn-outline-primary btn-sm fw-bold me-2">
                <i class="bi bi-filetype-json me-1"></i> OpenAPI Spec (JSON)
            </a>
            <a href="{{ url('/api/v1/health') }}" target="_blank" class="btn btn-outline-success btn-sm fw-bold">
                <i class="bi bi-activity me-1"></i> API Health Check
            </a>
        </div>
    </div>
</div>

<!-- Interactive Swagger UI Container -->
<div class="card border-0 shadow-sm bg-white p-3">
    <div id="swagger-ui"></div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/5.11.0/swagger-ui-bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/5.11.0/swagger-ui-standalone-preset.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        SwaggerUIBundle({
            url: "{{ url('/api/v1/openapi.json') }}",
            dom_id: '#swagger-ui',
            deepLinking: true,
            presets: [
                SwaggerUIBundle.presets.apis,
                SwaggerUIStandalonePreset
            ],
            layout: "BaseLayout"
        });
    });
</script>
@endsection
