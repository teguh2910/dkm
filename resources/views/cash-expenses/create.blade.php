@extends('layouts.app')

@section('title', 'Tambah Pengeluaran Kas Kecil')

@section('content')
    <div class="card">
        <div style="margin-bottom: 24px;">
            <h2 style="font-size: 20px; font-weight: 600; color: #1f2937;">Tambah Pengeluaran Kas Kecil</h2>
        </div>

        <form action="{{ route('cash-expenses.store') }}" method="POST" id="cashExpenseForm">
            @csrf

            <div class="form-group">
                <label for="barcode_id" class="form-label">Kode Barcode <span style="color: #ef4444;">*</span></label>
                <select name="barcode_id" id="barcode_id" class="form-control select2" required>
                    <option value="">-- Pilih Kode Barcode --</option>
                    @foreach ($barcodes as $barcode)
                        <option value="{{ $barcode->id }}" {{ old('barcode_id') == $barcode->id ? 'selected' : '' }}>
                            {{ $barcode->code }} - {{ $barcode->name }}
                        </option>
                    @endforeach
                </select>
                @error('barcode_id')
                    <div class="text-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="tanggal" class="form-label">Tanggal <span style="color: #ef4444;">*</span></label>
                <input type="date" name="tanggal" id="tanggal" class="form-control"
                    value="{{ old('tanggal', date('Y-m-d')) }}" required>
                @error('tanggal')
                    <div class="text-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="dibayarkan_kepada" class="form-label">Dibayarkan Kepada <span
                        style="color: #ef4444;">*</span></label>
                <input type="text" name="dibayarkan_kepada" id="dibayarkan_kepada" class="form-control"
                    value="{{ old('dibayarkan_kepada') }}" placeholder="Masukkan nama penerima" required>
                @error('dibayarkan_kepada')
                    <div class="text-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="sebesar" class="form-label">Sebesar (Rp) <span style="color: #ef4444;">*</span></label>
                <input type="number" name="sebesar" id="sebesar" class="form-control" value="{{ old('sebesar') }}"
                    placeholder="0" step="0.01" min="0" required>
                @error('sebesar')
                    <div class="text-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="terbilang" class="form-label">Terbilang <span style="color: #ef4444;">*</span></label>
                <input type="text" name="terbilang" id="terbilang" class="form-control" value="{{ old('terbilang') }}"
                    placeholder="Otomatis terisi setelah mengisi jumlah" readonly required>
                @error('terbilang')
                    <div class="text-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="expense_category_id" class="form-label">Kategori Pengeluaran <span
                        style="color: #ef4444;">*</span></label>
                <select name="expense_category_id" id="expense_category_id" class="form-control select2" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('expense_category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('expense_category_id')
                    <div class="text-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="keterangan2" class="form-label">Keterangan Tambahan</label>
                <textarea name="keterangan2" id="keterangan2" class="form-control" rows="3"
                    placeholder="Keterangan tambahan (opsional)">{{ old('keterangan2') }}</textarea>
                @error('keterangan2')
                    <div class="text-error">{{ $message }}</div>
                @enderror
            </div>

            <div style="margin-top: 24px; display: flex; gap: 12px;">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('cash-expenses.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/terbilang.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                theme: 'default',
                width: '100%'
            });

            // Auto-fill Terbilang
            $('#sebesar').on('input', function() {
                let value = $(this).val();
                if (value) {
                    let number = parseFloat(value);
                    if (!isNaN(number) && number > 0) {
                        let terbilang = angkaTerbilang(number);
                        terbilang = cleanTerbilang(terbilang);
                        $('#terbilang').val(terbilang + ' Rupiah');
                    } else {
                        $('#terbilang').val('');
                    }
                } else {
                    $('#terbilang').val('');
                }
            });

            // Format number input
            $('#sebesar').on('blur', function() {
                let value = $(this).val();
                if (value && !isNaN(value)) {
                    $(this).val(parseFloat(value).toFixed(2));
                }
            });
        });
    </script>
@endpush
