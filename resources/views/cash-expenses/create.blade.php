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
                <label for="year" class="form-label">Tahun <span style="color: #ef4444;">*</span></label>
                <select name="year" id="year" class="form-control" required>
                    <option value="">-- Pilih Tahun --</option>
                    @foreach ($years as $year)
                        <option value="{{ $year }}"
                            {{ old('year', $selectedYear ?? null) == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
                @error('year')
                    <div class="text-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="master_code_id" class="form-label">Master Code <span style="color: #ef4444;">*</span></label>
                <select name="master_code_id" id="master_code_id" class="form-control" required disabled>
                    <option value="">-- Pilih Tahun Terlebih Dahulu --</option>
                </select>
                @error('master_code_id')
                    <div class="text-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="barcode_id" class="form-label">Kode Barcode <span style="color: #ef4444;">*</span></label>
                <select name="barcode_id" id="barcode_id" class="form-control select2" required disabled>
                    <option value="">-- Pilih Master Code Terlebih Dahulu --</option>
                    @if ($barcodes->count() > 0)
                        @foreach ($barcodes as $barcode)
                            <option value="{{ $barcode->id }}"
                                {{ old('barcode_id', $selectedBarcodeId ?? null) == $barcode->id ? 'selected' : '' }}
                                data-budget="{{ $barcode->amount_budget }}" data-spent="{{ $barcode->spent_amount }}"
                                data-remaining="{{ $barcode->remaining_budget }}">
                                {{ $barcode->code }} - {{ $barcode->name }}
                                @if ($barcode->description)
                                    - {{ $barcode->description }}
                                @endif
                                @if ($barcode->amount_budget)
                                    (Sisa: Rp {{ number_format($barcode->remaining_budget, 0, ',', '.') }})
                                @endif
                            </option>
                        @endforeach
                    @endif
                </select>
                @error('barcode_id')
                    <div class="text-error">{{ $message }}</div>
                @enderror
                <div id="budget-info"
                    style="margin-top: 8px; padding: 8px; background-color: #eff6ff; border-radius: 6px; display: none;">
                    <small style="color: #1e40af;">
                        <strong>Sisa Budget:</strong> <span id="remaining-budget">-</span>
                    </small>
                </div>
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

            // Year change - load master codes
            $('#year').on('change', function() {
                const year = $(this).val();
                const masterCodeSelect = $('#master_code_id');
                const barcodeSelect = $('#barcode_id');

                // Reset downstream selects
                masterCodeSelect.html('<option value="">-- Loading... --</option>').prop('disabled', true);
                barcodeSelect.html('<option value="">-- Pilih Master Code Terlebih Dahulu --</option>')
                    .prop('disabled', true);
                $('#budget-info').hide();

                if (!year) {
                    masterCodeSelect.html('<option value="">-- Pilih Tahun Terlebih Dahulu --</option>');
                    return;
                }

                // Load master codes
                $.ajax({
                    url: `/api/master-codes/year/${year}`,
                    method: 'GET',
                    success: function(data) {
                        const selectedMasterCodeId =
                            '{{ old('master_code_id', $selectedMasterCodeId ?? '') }}';
                        masterCodeSelect.html(
                            '<option value="">-- Pilih Master Code --</option>');
                        data.forEach(function(mc) {
                            const selected = selectedMasterCodeId == mc.id ?
                                'selected' : '';
                            masterCodeSelect.append(
                                `<option value="${mc.id}" ${selected}>${mc.code} - ${mc.name}</option>`
                            );
                        });
                        masterCodeSelect.prop('disabled', false);

                        // If preselected, trigger change
                        @if (!empty($selectedMasterCodeId))
                            masterCodeSelect.trigger('change');
                        @endif
                    },
                    error: function() {
                        masterCodeSelect.html(
                            '<option value="">-- Error loading data --</option>');
                    }
                });
            });

            // Master Code change - load barcodes
            $('#master_code_id').on('change', function() {
                const masterCodeId = $(this).val();
                const year = $('#year').val();
                const barcodeSelect = $('#barcode_id');

                // Reset barcode select
                barcodeSelect.html('<option value="">-- Loading... --</option>').prop('disabled', true);
                $('#budget-info').hide();

                if (!masterCodeId) {
                    barcodeSelect.html('<option value="">-- Pilih Master Code Terlebih Dahulu --</option>');
                    return;
                }

                // Load barcodes
                $.ajax({
                    url: `/api/barcodes/master-code/${masterCodeId}/year/${year}`,
                    method: 'GET',
                    success: function(data) {
                        const selectedBarcodeId =
                            '{{ old('barcode_id', $selectedBarcodeId ?? '') }}';
                        barcodeSelect.html('<option value="">-- Pilih Barcode --</option>');
                        data.forEach(function(barcode) {
                            const remaining = barcode.amount_budget - barcode
                                .spent_amount;
                            const formatted = new Intl.NumberFormat('id-ID').format(
                                remaining);
                            const selected = selectedBarcodeId == barcode.id ?
                                'selected' : '';

                            let optionText = `${barcode.code} - ${barcode.name}`;
                            if (barcode.description) {
                                optionText += ` - ${barcode.description}`;
                            }
                            optionText += ` (Sisa: Rp ${formatted})`;

                            barcodeSelect.append(`
                                <option value="${barcode.id}" ${selected}
                                    data-budget="${barcode.amount_budget}"
                                    data-spent="${barcode.spent_amount}"
                                    data-remaining="${remaining}">
                                    ${optionText}
                                </option>
                            `);
                        });
                        barcodeSelect.prop('disabled', false);

                        // Reinitialize Select2
                        barcodeSelect.select2('destroy');
                        barcodeSelect.select2({
                            theme: 'default',
                            width: '100%'
                        });

                        // If preselected, trigger change
                        @if (!empty($selectedBarcodeId))
                            barcodeSelect.trigger('change');
                        @endif
                    },
                    error: function() {
                        barcodeSelect.html(
                            '<option value="">-- Error loading data --</option>');
                    }
                });
            });

            // Show budget info when barcode is selected
            $('#barcode_id').on('change', function() {
                const selectedOption = $(this).find(':selected');
                const remaining = selectedOption.data('remaining');

                if (remaining !== undefined && remaining !== null) {
                    const formatted = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(remaining);

                    $('#remaining-budget').text(formatted);
                    $('#budget-info').show();
                } else {
                    $('#budget-info').hide();
                }
            });

            // Trigger on page load if year is preselected
            @if (!empty($selectedYear))
                $('#year').trigger('change');
            @endif

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
