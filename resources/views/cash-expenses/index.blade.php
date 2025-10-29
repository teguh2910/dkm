@extends('layouts.app')

@section('title', 'Daftar Pengeluaran Kas Kecil')

@section('content')
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="font-size: 20px; font-weight: 600; color: #1f2937;">Daftar Pengeluaran Kas Kecil</h2>
            <div style="display: flex; gap: 8px;">
                <a href="{{ route('cash-expenses.download-format') }}" class="btn btn-success" target="_blank">
                    📄 Download Format Excel
                </a>
                <a href="{{ route('cash-expenses.create') }}" class="btn btn-primary">+ Tambah Pengeluaran</a>
            </div>
        </div>

        <div style="overflow-x: auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Tanggal</th>
                        <th>Kode Barcode</th>
                        <th>Dibayarkan Kepada</th>
                        <th style="text-align: right;">Jumlah</th>
                        <th>Kategori</th>
                        <th>Status Bendahara</th>
                        <th>Status Sekretaris</th>
                        <th>Status Ketua</th>
                        <th style="text-align: center; width: 200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expenses as $index => $expense)
                        <tr>
                            <td>{{ $expenses->firstItem() + $index }}</td>
                            <td>{{ $expense->tanggal->format('d/m/Y') }}</td>
                            <td>{{ $expense->barcode->code }}</td>
                            <td>{{ $expense->dibayarkan_kepada }}</td>
                            <td style="text-align: right;">Rp {{ number_format($expense->sebesar, 0, ',', '.') }}</td>
                            <td>{{ $expense->expenseCategory->name }}</td>
                            <td>
                                <span class="badge badge-{{ $expense->status_bendahara }}">
                                    {{ ucfirst($expense->status_bendahara) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $expense->status_sekretaris }}">
                                    {{ ucfirst($expense->status_sekretaris) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $expense->status_ketua }}">
                                    {{ ucfirst($expense->status_ketua) }}
                                </span>
                            </td>
                            <td style="text-align: center;">
                                <div style="display: flex; gap: 4px; justify-content: center;">
                                    <a href="{{ route('cash-expenses.show', $expense) }}" class="btn btn-secondary"
                                        style="padding: 6px 12px; font-size: 13px;">Detail</a>
                                    <a href="{{ route('cash-expenses.edit', $expense) }}" class="btn btn-warning"
                                        style="padding: 6px 12px; font-size: 13px;">Edit</a>
                                    <form action="{{ route('cash-expenses.destroy', $expense) }}" method="POST"
                                        style="display: inline;"
                                        onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            style="padding: 6px 12px; font-size: 13px;">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" style="text-align: center; padding: 40px; color: #6b7280;">
                                Belum ada data pengeluaran kas kecil
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($expenses->hasPages())
            <div style="margin-top: 20px;">
                {{ $expenses->links() }}
            </div>
        @endif
    </div>
@endsection
