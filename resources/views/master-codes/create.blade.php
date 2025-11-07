@extends('layouts.app')

@section('title', 'Tambah Master Code')

@section('content')
    <div class="card">
        <div style="margin-bottom: 24px;">
            <h2 style="font-size: 20px; font-weight: 600; color: #1f2937;">Tambah Master Code</h2>
        </div>

        <form action="{{ route('master-codes.store') }}" method="POST">
            @csrf

            <div style="margin-bottom: 16px;">
                <label for="code" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">
                    Kode <span style="color: #ef4444;">*</span>
                </label>
                <input type="text" id="code" name="code" value="{{ old('code') }}" required
                    placeholder="Contoh: MC-2025-001"
                    style="display: block; width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
                @error('code')
                    <span style="color: #ef4444; font-size: 14px; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 16px;">
                <label for="name" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">
                    Nama <span style="color: #ef4444;">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    placeholder="Nama Master Code"
                    style="display: block; width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
                @error('name')
                    <span style="color: #ef4444; font-size: 14px; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 16px;">
                <label for="description" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">
                    Deskripsi
                </label>
                <textarea id="description" name="description" rows="3" placeholder="Deskripsi master code (opsional)"
                    style="display: block; width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">{{ old('description') }}</textarea>
                @error('description')
                    <span style="color: #ef4444; font-size: 14px; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 16px;">
                <label for="year" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">
                    Tahun <span style="color: #ef4444;">*</span>
                </label>
                <input type="number" id="year" name="year" value="{{ old('year', date('Y')) }}" required
                    min="2000" max="2100"
                    style="display: block; width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
                @error('year')
                    <span style="color: #ef4444; font-size: 14px; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div style="display: flex; gap: 8px; margin-top: 24px;">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('master-codes.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection
