@extends('layouts.app')

@section('title', 'Analysis | Zerox – Pharmaceuticals')

@section('content')
<!-- Analysis Hero Banner -->
<section class="banner" style="position: relative;">
    <img src="{{ asset('img/analysis-banner.png') }}" alt="Analysis Banner" style="width: 100%; max-height: 380px; object-fit: cover;">
</section>

<!-- Analysis Content Section matching Zerox.com styling -->
<section style="padding: 60px 0; background: #fff;">
    <div class="container">
        <div style="margin-bottom: 40px;">
            <h2 style="font-size: 28px; font-weight: 700; color: #111; margin: 0 0 10px 0; position: relative; padding-bottom: 12px; border-bottom: 3px solid #c9a227; display: inline-block;">
                Independent Quality Control & Analysis
            </h2>
            <p style="color: #666; font-size: 15px; line-height: 1.6; margin-top: 15px;">
                Zerox Pharmaceuticals Ltd subjects every manufactured batch to rigorous third-party analytical testing. High-Performance Liquid Chromatography (HPLC) assays, gas chromatography-mass spectrometry (GC-MS), sterility, and endotoxin tests ensure every product meets international USP and EP pharmaceutical standards.
            </p>
        </div>

        <!-- Verified Lab Test Reports Table -->
        <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); margin-bottom: 40px;">
            <h3 style="font-size: 20px; font-weight: 700; color: #111; margin-top: 0; margin-bottom: 20px; color: #c9a227;">
                <i class="bi bi-file-earmark-medical-fill me-2"></i> Verified Batch Testing Certificates
            </h3>

            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 14px; text-align: left;">
                    <thead>
                        <tr style="background: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                            <th style="padding: 12px 15px; color: #333; font-weight: 700;">Report Title</th>
                            <th style="padding: 12px 15px; color: #333; font-weight: 700;">Batch Number</th>
                            <th style="padding: 12px 15px; color: #333; font-weight: 700;">HPLC Purity</th>
                            <th style="padding: 12px 15px; color: #333; font-weight: 700;">Test Date</th>
                            <th style="padding: 12px 15px; color: #333; font-weight: 700;">Status</th>
                            <th style="padding: 12px 15px; color: #333; font-weight: 700; text-align: right;">Certificate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($labReports))
                            @foreach($labReports as $report)
                                <tr style="border-bottom: 1px solid #eee;">
                                    <td style="padding: 14px 15px; font-weight: 600; color: #111;">{{ $report['title'] }}</td>
                                    <td style="padding: 14px 15px;"><span style="background: #e2e8f0; padding: 3px 8px; border-radius: 4px; font-family: monospace; font-weight: 600;">{{ $report['batch'] }}</span></td>
                                    <td style="padding: 14px 15px;"><strong style="color: #28a745; font-size: 15px;">{{ $report['purity'] }}</strong></td>
                                    <td style="padding: 14px 15px; color: #666;">{{ $report['date'] }}</td>
                                    <td style="padding: 14px 15px;"><span style="background: #d4edda; color: #155724; padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: 700;">PASSED</span></td>
                                    <td style="padding: 14px 15px; text-align: right;">
                                        <button onclick="alert('Downloading Certificate for batch {{ $report['batch'] }}...');" style="background: #c9a227; color: #000; font-weight: 700; font-size: 12px; border: none; padding: 7px 15px; border-radius: 4px; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#b89320';" onmouseout="this.style.background='#c9a227';">
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

        <!-- Quality Assurance Banner -->
        <div style="background: #1e293b; color: #fff; border-radius: 8px; padding: 30px; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between;">
            <div style="max-width: 700px;">
                <h3 style="font-size: 20px; font-weight: 700; color: #c9a227; margin-top: 0; margin-bottom: 8px;">GMP & ISO 9001 Certified Manufacturing</h3>
                <p style="color: #aaa; margin: 0; font-size: 14px; line-height: 1.6;">
                    All analytical tests are conducted by ISO 17025 accredited laboratories using reference standards traceable to the European Pharmacopoeia (EP) and United States Pharmacopeia (USP).
                </p>
            </div>
            <div style="margin-top: 15px;">
                <a href="{{ route('contact') }}" style="display: inline-block; background: #c9a227; color: #000; font-weight: 700; padding: 10px 22px; border-radius: 4px; text-decoration: none;">Request Custom Assay</a>
            </div>
        </div>
    </div>
</section>
@endsection
