@extends('layouts.app')

@section('title', 'Upload Master Code Excel')

@section('content')
    <div class="card">
        <div style="margin-bottom: 24px;">
            <h2 style="font-size: 20px; font-weight: 600; color: #1f2937; margin-bottom: 8px;">Upload Master Code Excel</h2>
            <p style="color: #6b7280; font-size: 14px;">Upload file Excel untuk import data master code secara massal</p>
        </div>

        @if (session('success'))
            <div
                style="background-color: #d1fae5; color: #065f46; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px;">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div
                style="background-color: #fee2e2; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px;">
                {{ session('error') }}
            </div>
        @endif

        <div
            style="background-color: #dbeafe; border-left: 4px solid #3b82f6; padding: 16px; margin-bottom: 24px; border-radius: 4px;">
            <h3 style="font-size: 14px; font-weight: 600; color: #1e40af; margin-bottom: 8px;">📋 Format Excel yang
                Diperlukan:</h3>
            <ul style="margin: 0; padding-left: 20px; color: #1e40af; font-size: 14px;">
                <li>Kolom 1: <strong>Code</strong> (Kode Master Code, contoh: MC-2025-001)</li>
                <li>Kolom 2: <strong>Name</strong> (Nama Master Code)</li>
                <li>Kolom 3: <strong>Description</strong> (Deskripsi, opsional)</li>
                <li>Kolom 4: <strong>Year</strong> (Tahun, contoh: 2025)</li>
            </ul>
            <p style="margin: 12px 0 0 0; color: #1e40af; font-size: 13px;">
                💡 <strong>Tips:</strong> Download template Excel terlebih dahulu untuk memastikan format yang benar.
            </p>
        </div>

        <form action="{{ route('master-codes.upload.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div style="margin-bottom: 16px;">
                <label for="file" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">
                    File Excel <span style="color: #ef4444;">*</span>
                </label>
                <input type="file" id="file" name="file" accept=".xlsx,.xls,.csv" required
                    style="display: block; width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
                @error('file')
                    <span style="color: #ef4444; font-size: 14px; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div style="display: flex; gap: 8px; margin-top: 24px;">
                <button type="submit" class="btn btn-primary">
                    📤 Upload & Import
                </button>
                <a href="{{ route('master-codes.index') }}" class="btn btn-secondary">
                    Batal
                </a>
                <a href="{{ route('master-codes.template') }}" class="btn btn-info">
                    📥 Download Template
                </a>
            </div>
        </form>
    </div>
@endsection
