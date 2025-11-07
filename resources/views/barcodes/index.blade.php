@extends('layouts.app')

@section('title', 'Daftar Barcode')

@section('content')
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h2 style="font-size: 20px; font-weight: 600; color: #1f2937;">Daftar Barcode</h2>
            @if (Auth::user()->isDeptPic())
                <div style="display: flex; gap: 8px;">
                    <a href="{{ route('barcodes.upload') }}" class="btn btn-success">📤 Upload Excel</a>
                    <a href="{{ route('barcodes.template') }}" class="btn btn-info">📥 Download Template</a>
                    <a href="{{ route('barcodes.create') }}" class="btn btn-primary">Tambah Barcode</a>
                </div>
            @endif
        </div>

        @if (session('success'))
            <div
                style="background-color: #d1fae5; color: #065f46; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px;">
                {{ session('success') }}
            </div>
        @endif

        @if (session('warning'))
            <div
                style="background-color: #fef3c7; color: #92400e; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px;">
                {{ session('warning') }}
            </div>
        @endif

        @if (session('error'))
            <div
                style="background-color: #fee2e2; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px;">
                {{ session('error') }}
            </div>
        @endif

        <div style="overflow-x: auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Section</th>
                        <th>Kode Barcode</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Budget</th>
                        <th>Tahun</th>
                        <th>Status</th>
                        @if (Auth::user()->isDeptPic())
                            <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($barcodes as $index => $barcode)
                        <tr>
                            <td>{{ $barcodes->firstItem() + $index }}</td>
                            <td>
                                @if ($barcode->masterCode)
                                    <div style="font-size: 12px; color: #6b7280;">
                                        {{ $barcode->masterCode->code }}
                                    </div>
                                @else
                                    <span style="color: #9ca3af;">-</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('barcodes.show', $barcode) }}"
                                    style="color: #3b82f6; font-weight: 600; text-decoration: none;">
                                    {{ $barcode->code }}
                                </a>
                            </td>
                            <td>{{ $barcode->name }}</td>
                            <td>{{ Str::limit($barcode->description, 50) }}</td>
                            <td>
                                @if ($barcode->amount_budget)
                                    <div style="font-weight: 600;">Rp
                                        {{ number_format($barcode->amount_budget, 0, ',', '.') }}</div>
                                    <div style="font-size: 11px; color: #6b7280;">
                                        Sisa: Rp {{ number_format($barcode->remaining_budget, 0, ',', '.') }}
                                    </div>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $barcode->year ?? '-' }}</td>
                            <td>
                                @if ($barcode->is_active)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-secondary">Non-Aktif</span>
                                @endif
                            </td>
                            @if (Auth::user()->isDeptPic())
                                <td>
                                    <div style="display: flex; gap: 4px;">
                                        <a href="{{ route('barcodes.edit', $barcode) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('barcodes.destroy', $barcode) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus barcode ini?')">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ Auth::user()->isDeptPic() ? '9' : '8' }}"
                                style="text-align: center; padding: 24px; color: #6b7280;">
                                Belum ada data barcode.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 16px;">
            {{ $barcodes->links() }}
        </div>
    </div>
@endsection
