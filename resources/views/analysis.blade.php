@extends('layouts.app')

@section('title', 'Lab Analysis & Certificates - Zerox Pharmaceuticals')

@section('content')
<div class="bg-dark text-white py-5 mb-5" style="background: linear-gradient(135deg, #091528, #0f2342);">
    <div class="container text-center py-4">
        <h1 class="display-5 fw-bold mb-2">Third-Party Lab Analysis & Certificates</h1>
        <p class="lead text-info max-w-2xl mx-auto">Verifiable HPLC assays, endotoxin testing, and purity mass spectrometry reports for complete transparency.</p>
    </div>
</div>

<div class="container pb-5">
    <div class="card card-zx shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <h4 class="fw-bold mb-3"><i class="bi bi-file-earmark-medical-fill text-info me-2"></i> Verified Batch Testing Reports</h4>
            <p class="text-muted mb-4">Select any batch report below to review quantitative analytical assays conducted by independent analytical laboratories.</p>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Report Title</th>
                            <th>Batch Number</th>
                            <th>Tested Purity</th>
                            <th>Test Date</th>
                            <th>Status</th>
                            <th>Certificate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($labReports))
                            @foreach($labReports as $report)
                                <tr>
                                    <td class="fw-bold text-dark">{{ $report['title'] }}</td>
                                    <td><span class="badge bg-dark font-monospace">{{ $report['batch'] }}</span></td>
                                    <td><strong class="text-success">{{ $report['purity'] }}</strong></td>
                                    <td class="text-muted small">{{ $report['date'] }}</td>
                                    <td><span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25"><i class="bi bi-check-all me-1"></i> Passed</span></td>
                                    <td>
                                        <button class="btn btn-outline-primary btn-sm rounded-pill" onclick="alert('Downloading Certificate for {{ $report['batch'] }}...');">
                                            <i class="bi bi-download me-1"></i> Download PDF
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
