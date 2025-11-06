@extends('layouts.app')

@section('title', 'Detail Barcode')

@section('content')
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h2 style="font-size: 20px; font-weight: 600; color: #1f2937;">Detail Barcode</h2>
            <div style="display: flex; gap: 8px;">
                @if (Auth::user()->isDeptPic())
                    <a href="{{ route('cash-expenses.create', ['barcode' => $barcode->id]) }}" class="btn btn-primary">
                        ➕ Add Expense
                    </a>
                    <a href="{{ route('barcodes.edit', $barcode) }}" class="btn btn-warning">Edit</a>
                @endif
                <a href="{{ route('barcodes.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>

        <!-- Barcode Info -->
        <div style="background-color: #f9fafb; padding: 20px; border-radius: 8px; margin-bottom: 24px;">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;">
                <div>
                    <label style="font-size: 12px; color: #6b7280; display: block; margin-bottom: 4px;">Kode Barcode</label>
                    <div style="font-size: 16px; font-weight: 600; color: #1f2937;">{{ $barcode->code }}</div>
                </div>
                <div>
                    <label style="font-size: 12px; color: #6b7280; display: block; margin-bottom: 4px;">Nama</label>
                    <div style="font-size: 16px; font-weight: 600; color: #1f2937;">{{ $barcode->name }}</div>
                </div>
                <div>
                    <label style="font-size: 12px; color: #6b7280; display: block; margin-bottom: 4px;">Tahun</label>
                    <div style="font-size: 16px; font-weight: 600; color: #1f2937;">{{ $barcode->year ?? '-' }}</div>
                </div>
                <div>
                    <label style="font-size: 12px; color: #6b7280; display: block; margin-bottom: 4px;">Status</label>
                    <div>
                        @if ($barcode->is_active)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-secondary">Non-Aktif</span>
                        @endif
                    </div>
                </div>
                @if ($barcode->description)
                    <div style="grid-column: span 2;">
                        <label
                            style="font-size: 12px; color: #6b7280; display: block; margin-bottom: 4px;">Deskripsi</label>
                        <div style="font-size: 14px; color: #374151;">{{ $barcode->description }}</div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Budget Info -->
        @if ($barcode->amount_budget)
            <div
                style="background-color: #eff6ff; padding: 20px; border-radius: 8px; margin-bottom: 24px; border: 1px solid #bfdbfe;">
                <h3 style="font-size: 16px; font-weight: 600; color: #1e40af; margin-bottom: 16px;">📊 Budget Information
                </h3>

                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 16px;">
                    <div>
                        <label style="font-size: 12px; color: #1e40af; display: block; margin-bottom: 4px;">Total
                            Budget</label>
                        <div style="font-size: 18px; font-weight: 700; color: #1e40af;">
                            Rp {{ number_format($barcode->amount_budget, 0, ',', '.') }}
                        </div>
                    </div>
                    <div>
                        <label style="font-size: 12px; color: #dc2626; display: block; margin-bottom: 4px;">Terpakai</label>
                        <div style="font-size: 18px; font-weight: 700; color: #dc2626;">
                            Rp {{ number_format($barcode->spent_amount, 0, ',', '.') }}
                        </div>
                    </div>
                    <div>
                        <label style="font-size: 12px; color: #059669; display: block; margin-bottom: 4px;">Sisa
                            Budget</label>
                        <div style="font-size: 18px; font-weight: 700; color: #059669;">
                            Rp {{ number_format($barcode->remaining_budget, 0, ',', '.') }}
                        </div>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span style="font-size: 12px; color: #1e40af;">Budget Usage</span>
                        <span style="font-size: 12px; font-weight: 600; color: #1e40af;">
                            {{ number_format($barcode->budget_percentage, 1) }}%
                        </span>
                    </div>
                    <div style="background-color: #dbeafe; height: 12px; border-radius: 6px; overflow: hidden;">
                        <div
                            style="background-color: {{ $barcode->budget_percentage > 90 ? '#dc2626' : ($barcode->budget_percentage > 75 ? '#f59e0b' : '#3b82f6') }}; height: 100%; width: {{ min($barcode->budget_percentage, 100) }}%; transition: width 0.3s;">
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Recent Expenses -->
        <div>
            <h3 style="font-size: 16px; font-weight: 600; color: #1f2937; margin-bottom: 16px;">
                📝 Recent Expenses ({{ $barcode->cashExpenses->count() }} latest)
            </h3>

            @if ($barcode->cashExpenses->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Dibayar Kepada</th>
                                <th>Jumlah</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barcode->cashExpenses as $expense)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($expense->date)->format('d/m/Y') }}</td>
                                    <td>{{ $expense->paid_to }}</td>
                                    <td style="font-weight: 600;">Rp {{ number_format($expense->amount, 0, ',', '.') }}
                                    </td>
                                    <td>{{ $expense->expenseCategory->name ?? '-' }}</td>
                                    <td>
                                        @if ($expense->isFullyApproved())
                                            <span class="badge badge-approved">✓ Approved</span>
                                        @elseif($expense->hasRejection())
                                            <span class="badge badge-rejected">✗ Rejected</span>
                                        @else
                                            <span class="badge badge-pending">⏳ Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('cash-expenses.show', $expense) }}"
                                            class="btn btn-sm btn-primary">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: 16px; text-align: center;">
                    <a href="{{ route('cash-expenses.index', ['barcode' => $barcode->id]) }}" class="btn btn-secondary">
                        Lihat Semua Expenses
                    </a>
                </div>
            @else
                <div
                    style="background-color: #f9fafb; padding: 40px; text-align: center; border-radius: 8px; color: #6b7280;">
                    <div style="font-size: 48px; margin-bottom: 12px;">📭</div>
                    <div style="font-size: 16px; font-weight: 500;">Belum ada expense untuk barcode ini</div>
                    @if (Auth::user()->isDeptPic())
                        <div style="margin-top: 16px;">
                            <a href="{{ route('cash-expenses.create', ['barcode' => $barcode->id]) }}"
                                class="btn btn-primary">
                                Buat Expense Pertama
                            </a>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
@endsection
