@extends('layouts.app')

@section('title', 'Upload Barcode Excel')

@section('content')
    <div class="card">
        <div style="margin-bottom: 24px;">
            <h2 style="font-size: 20px; font-weight: 600; color: #1f2937;">Upload Data Barcode</h2>
            <p style="color: #6b7280; margin-top: 4px;">Upload file Excel untuk import data barcode secara massal</p>
        </div>

        @if (session('error'))
            <div
                style="background-color: #fee2e2; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px;">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div
                style="background-color: #fee2e2; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div
            style="background-color: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 16px; margin-bottom: 24px;">
            <h3 style="font-size: 14px; font-weight: 600; color: #1e40af; margin-bottom: 8px;">📋 Format Excel yang
                Diperlukan:</h3>
            <ul style="color: #1e40af; margin: 0; padding-left: 20px; font-size: 14px;">
                <li><strong>Kolom A:</strong> Kode Barcode (Wajib)</li>
                <li><strong>Kolom B:</strong> Deskripsi</li>
                <li><strong>Kolom C:</strong> Amount Budget (Angka)</li>
                <li><strong>Kolom D:</strong> Tahun (Format: 2025)</li>
            </ul>
            <p style="color: #1e40af; margin-top: 12px; margin-bottom: 0; font-size: 14px;">
                <strong>Catatan:</strong> Baris pertama (header) akan diabaikan. Pastikan data dimulai dari baris ke-2.
            </p>
        </div>

        <form action="{{ route('barcodes.upload.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 8px;">
                    File Excel <span style="color: #dc2626;">*</span>
                </label>
                <input type="file" name="file" accept=".xlsx,.xls,.csv" required
                    style="display: block; width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
                <p style="color: #6b7280; font-size: 12px; margin-top: 4px;">
                    Format yang diterima: .xlsx, .xls, .csv (Maksimal 2MB)
                </p>
            </div>

            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                <a href="{{ route('barcodes.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Upload & Import</button>
            </div>
        </form>

        <div style="margin-top: 24px; padding-top: 24px; border-top: 1px solid #e5e7eb;">
            <p style="color: #6b7280; font-size: 14px; margin-bottom: 8px;">
                <strong>Belum punya template?</strong>
            </p>
            <a href="{{ route('barcodes.template') }}" class="btn btn-info">
                📥 Download Template Excel
            </a>
        </div>
    </div>
@endsection
