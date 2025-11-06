@extends('layouts.app')

@section('title', 'Edit Barcode')

@section('content')
    <div class="card">
        <div style="margin-bottom: 24px;">
            <h2 style="font-size: 20px; font-weight: 600; color: #1f2937;">Edit Barcode</h2>
        </div>

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

        <form action="{{ route('barcodes.update', $barcode) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 8px;">
                    Kode Barcode <span style="color: #dc2626;">*</span>
                </label>
                <input type="text" name="code" value="{{ old('code', $barcode->code) }}" required
                    style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;"
                    placeholder="Masukkan kode barcode">
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 8px;">
                    Nama <span style="color: #dc2626;">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name', $barcode->name) }}" required
                    style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;"
                    placeholder="Masukkan nama barcode">
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 8px;">
                    Deskripsi
                </label>
                <textarea name="description" rows="3"
                    style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;"
                    placeholder="Masukkan deskripsi">{{ old('description', $barcode->description) }}</textarea>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 8px;">
                    Amount Budget
                </label>
                <input type="number" name="amount_budget" value="{{ old('amount_budget', $barcode->amount_budget) }}"
                    step="0.01" min="0"
                    style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;"
                    placeholder="Masukkan jumlah budget">
            </div>

            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 8px;">
                    Tahun
                </label>
                <input type="number" name="year" value="{{ old('year', $barcode->year) }}" min="2000" max="2100"
                    style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;"
                    placeholder="Masukkan tahun">
            </div>

            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                <a href="{{ route('barcodes.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
@endsection
