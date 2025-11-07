@extends('layouts.app')

@section('title', 'Daftar Master Code')

@section('content')
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h2 style="font-size: 20px; font-weight: 600; color: #1f2937;">Daftar Master Code</h2>
            @if (Auth::user()->isDeptPic())
                <div style="display: flex; gap: 8px;">
                    <a href="{{ route('master-codes.upload') }}" class="btn btn-success">📤 Upload Excel</a>
                    <a href="{{ route('master-codes.template') }}" class="btn btn-info">📥 Download Template</a>
                    <a href="{{ route('master-codes.create') }}" class="btn btn-primary">Tambah Master Code</a>
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
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Tahun</th>
                        <th>Jumlah Barcode</th>
                        <th>Status</th>
                        @if (Auth::user()->isDeptPic())
                            <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($masterCodes as $masterCode)
                        <tr>
                            <td>{{ $loop->iteration + ($masterCodes->currentPage() - 1) * $masterCodes->perPage() }}</td>
                            <td><strong>{{ $masterCode->code }}</strong></td>
                            <td>{{ $masterCode->name }}</td>
                            <td>{{ $masterCode->description ?? '-' }}</td>
                            <td>{{ $masterCode->year }}</td>
                            <td>{{ $masterCode->barcodes->count() }}</td>
                            <td>
                                @if ($masterCode->is_active)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-secondary">Nonaktif</span>
                                @endif
                            </td>
                            @if (Auth::user()->isDeptPic())
                                <td>
                                    <div style="display: flex; gap: 4px;">
                                        <a href="{{ route('master-codes.edit', $masterCode) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('master-codes.destroy', $masterCode) }}" method="POST"
                                            style="display: inline;"
                                            onsubmit="return confirm('Yakin ingin menghapus master code ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ Auth::user()->isDeptPic() ? 8 : 7 }}" style="text-align: center;">Tidak ada
                                data master code</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 16px;">
            {{ $masterCodes->links() }}
        </div>
    </div>
@endsection
