@extends('layouts.app')

@section('title', 'Detail Pengeluaran Kas Kecil')

@section('content')
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h2 style="font-size: 20px; font-weight: 600; color: #1f2937;">Detail Pengeluaran Kas Kecil</h2>
            <div style="display: flex; gap: 8px;">
                <button onclick="window.print()" class="btn btn-success">🖨️ Print</button>
                @if (Auth::user()->isDeptPic())
                    <a href="{{ route('cash-expenses.edit', $cashExpense) }}" class="btn btn-warning">Edit</a>
                @endif
                <a href="{{ route('cash-expenses.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px;">
            <div>
                <div style="margin-bottom: 16px;">
                    <label
                        style="display: block; font-weight: 600; color: #6b7280; font-size: 13px; margin-bottom: 4px;">Kode
                        Barcode</label>
                    <div style="font-size: 15px; color: #1f2937;">{{ $cashExpense->barcode->code }} -
                        {{ $cashExpense->barcode->name }}</div>
                </div>

                <div style="margin-bottom: 16px;">
                    <label
                        style="display: block; font-weight: 600; color: #6b7280; font-size: 13px; margin-bottom: 4px;">Tanggal</label>
                    <div style="font-size: 15px; color: #1f2937;">{{ $cashExpense->tanggal->format('d F Y') }}</div>
                </div>

                <div style="margin-bottom: 16px;">
                    <label
                        style="display: block; font-weight: 600; color: #6b7280; font-size: 13px; margin-bottom: 4px;">Dibayarkan
                        Kepada</label>
                    <div style="font-size: 15px; color: #1f2937;">{{ $cashExpense->dibayarkan_kepada }}</div>
                </div>

                <div style="margin-bottom: 16px;">
                    <label
                        style="display: block; font-weight: 600; color: #6b7280; font-size: 13px; margin-bottom: 4px;">Sebesar</label>
                    <div style="font-size: 18px; color: #1f2937; font-weight: 600;">Rp
                        {{ number_format($cashExpense->sebesar, 0, ',', '.') }}</div>
                </div>

                <div style="margin-bottom: 16px;">
                    <label
                        style="display: block; font-weight: 600; color: #6b7280; font-size: 13px; margin-bottom: 4px;">Terbilang</label>
                    <div style="font-size: 15px; color: #1f2937; font-style: italic;">{{ $cashExpense->terbilang }}</div>
                </div>
            </div>

            <div>
                <div style="margin-bottom: 16px;">
                    <label
                        style="display: block; font-weight: 600; color: #6b7280; font-size: 13px; margin-bottom: 4px;">Keterangan
                        Tambahan</label>
                    <div style="font-size: 15px; color: #1f2937;">{{ $cashExpense->keterangan2 ?? '-' }}</div>
                </div>

                <div style="margin-bottom: 16px;">
                    <label
                        style="display: block; font-weight: 600; color: #6b7280; font-size: 13px; margin-bottom: 4px;">Dibuat
                        Pada</label>
                    <div style="font-size: 15px; color: #1f2937;">{{ $cashExpense->created_at->format('d F Y H:i') }}</div>
                </div>

                <div style="margin-bottom: 16px;">
                    <label
                        style="display: block; font-weight: 600; color: #6b7280; font-size: 13px; margin-bottom: 4px;">Terakhir
                        Diupdate</label>
                    <div style="font-size: 15px; color: #1f2937;">{{ $cashExpense->updated_at->format('d F Y H:i') }}</div>
                </div>
            </div>
        </div>

        <hr style="margin: 24px 0; border: none; border-top: 1px solid #e5e7eb;">

        <h3 style="font-size: 18px; font-weight: 600; color: #1f2937; margin-bottom: 16px;">Status Approval</h3>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;">
            <div style="padding: 16px; background: #f9fafb; border-radius: 8px; border: 1px solid #e5e7eb;">
                <div style="font-weight: 600; color: #6b7280; font-size: 13px; margin-bottom: 8px;">Bendahara</div>
                <div>
                    <span class="badge badge-{{ $cashExpense->status_bendahara }}">
                        {{ ucfirst($cashExpense->status_bendahara) }}
                    </span>
                </div>
                @if ($cashExpense->approved_bendahara_at)
                    <div style="font-size: 12px; color: #6b7280; margin-top: 8px;">
                        {{ $cashExpense->approved_bendahara_at->format('d/m/Y H:i') }}
                    </div>
                @endif
            </div>

            <div style="padding: 16px; background: #f9fafb; border-radius: 8px; border: 1px solid #e5e7eb;">
                <div style="font-weight: 600; color: #6b7280; font-size: 13px; margin-bottom: 8px;">Sekretaris</div>
                <div>
                    <span class="badge badge-{{ $cashExpense->status_sekretaris }}">
                        {{ ucfirst($cashExpense->status_sekretaris) }}
                    </span>
                </div>
                @if ($cashExpense->approved_sekretaris_at)
                    <div style="font-size: 12px; color: #6b7280; margin-top: 8px;">
                        {{ $cashExpense->approved_sekretaris_at->format('d/m/Y H:i') }}
                    </div>
                @endif
            </div>

            <div style="padding: 16px; background: #f9fafb; border-radius: 8px; border: 1px solid #e5e7eb;">
                <div style="font-weight: 600; color: #6b7280; font-size: 13px; margin-bottom: 8px;">Ketua</div>
                <div>
                    <span class="badge badge-{{ $cashExpense->status_ketua }}">
                        {{ ucfirst($cashExpense->status_ketua) }}
                    </span>
                </div>
                @if ($cashExpense->approved_ketua_at)
                    <div style="font-size: 12px; color: #6b7280; margin-top: 8px;">
                        {{ $cashExpense->approved_ketua_at->format('d/m/Y H:i') }}
                    </div>
                @endif
            </div>
        </div>

        {{-- Approval Actions --}}
        <div style="margin-top: 24px;">
            @if (Auth::user()->isBendahara() && $cashExpense->status_bendahara === 'pending')
                <div style="padding: 16px; background: #fef3c7; border: 1px solid #fbbf24; border-radius: 8px;">
                    <h4 style="font-weight: 600; margin-bottom: 12px;">Approval Bendahara</h4>
                    <div style="display: flex; gap: 8px;">
                        <form action="{{ route('cash-expenses.approval', [$cashExpense, 'bendahara', 'approved']) }}"
                            method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success"
                                onclick="return confirm('Approve pengeluaran ini?')">
                                ✓ Approve
                            </button>
                        </form>
                        <form action="{{ route('cash-expenses.approval', [$cashExpense, 'bendahara', 'rejected']) }}"
                            method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Reject pengeluaran ini?')">
                                ✗ Reject
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            @if (Auth::user()->isSekretaris() && $cashExpense->status_sekretaris === 'pending')
                @if ($cashExpense->status_bendahara === 'approved')
                    <div style="padding: 16px; background: #fef3c7; border: 1px solid #fbbf24; border-radius: 8px;">
                        <h4 style="font-weight: 600; margin-bottom: 12px;">Approval Sekretaris</h4>
                        <div style="display: flex; gap: 8px;">
                            <form action="{{ route('cash-expenses.approval', [$cashExpense, 'sekretaris', 'approved']) }}"
                                method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success"
                                    onclick="return confirm('Approve pengeluaran ini?')">
                                    ✓ Approve
                                </button>
                            </form>
                            <form action="{{ route('cash-expenses.approval', [$cashExpense, 'sekretaris', 'rejected']) }}"
                                method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Reject pengeluaran ini?')">
                                    ✗ Reject
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div
                        style="padding: 16px; background: #f3f4f6; border: 1px solid #d1d5db; border-radius: 8px; color: #6b7280;">
                        Menunggu approval dari Bendahara terlebih dahulu
                    </div>
                @endif
            @endif

            @if (Auth::user()->isKetua() && $cashExpense->status_ketua === 'pending')
                @if ($cashExpense->status_bendahara === 'approved' && $cashExpense->status_sekretaris === 'approved')
                    <div style="padding: 16px; background: #fef3c7; border: 1px solid #fbbf24; border-radius: 8px;">
                        <h4 style="font-weight: 600; margin-bottom: 12px;">Approval Ketua</h4>
                        <div style="display: flex; gap: 8px;">
                            <form action="{{ route('cash-expenses.approval', [$cashExpense, 'ketua', 'approved']) }}"
                                method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success"
                                    onclick="return confirm('Approve pengeluaran ini?')">
                                    ✓ Approve
                                </button>
                            </form>
                            <form action="{{ route('cash-expenses.approval', [$cashExpense, 'ketua', 'rejected']) }}"
                                method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Reject pengeluaran ini?')">
                                    ✗ Reject
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div
                        style="padding: 16px; background: #f3f4f6; border: 1px solid #d1d5db; border-radius: 8px; color: #6b7280;">
                        Menunggu approval dari Bendahara dan Sekretaris terlebih dahulu
                    </div>
                @endif
            @endif
        </div>

        @if ($cashExpense->isFullyApproved())
            <div
                style="margin-top: 20px; padding: 12px; background: #d1fae5; border: 1px solid #6ee7b7; border-radius: 6px; color: #065f46;">
                <strong>✓ Pengeluaran ini telah disetujui oleh semua pihak</strong>
            </div>
        @elseif($cashExpense->hasRejection())
            <div
                style="margin-top: 20px; padding: 12px; background: #fee2e2; border: 1px solid #fca5a5; border-radius: 6px; color: #991b1b;">
                <strong>✗ Pengeluaran ini ditolak oleh salah satu pihak</strong>
            </div>
        @endif
    </div>
@endsection
