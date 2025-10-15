@extends('layouts.admin')

@section('title', 'Detail Kegiatan')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4">📋 Detail Kegiatan</h2>

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">

            {{-- 🔹 Bagian Foto (bisa banyak) --}}
            <div class="mb-4 text-center">
                @php
                    $fotos = json_decode($kegiatan->foto, true);
                @endphp

                @if(!empty($fotos) && is_array($fotos))
                    <div class="d-flex justify-content-center flex-wrap gap-3">
                        @foreach($fotos as $foto)
                            <img src="{{ asset('storage/' . $foto) }}" 
                                 alt="Foto {{ $kegiatan->judul }}" 
                                 class="rounded shadow-sm"
                                 style="width: 180px; height: 130px; object-fit: cover;">
                        @endforeach
                    </div>
                @else
                    <span class="text-muted fst-italic">Tidak ada foto</span>
                @endif
            </div>

            {{-- 🔹 Tabel Informasi --}}
            <table class="table table-bordered align-middle">
                <tr>
                    <th style="width: 25%">Judul</th>
                    <td>{{ $kegiatan->judul }}</td>
                </tr>
                <tr>
                    <th>Deskripsi</th>
                    <td>
                        <div class="quill-content">
                            {!! $kegiatan->deskripsi !!}
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Tanggal Dibuat</th>
                    <td>{{ $kegiatan->created_at->format('d M Y') }}</td>
                </tr>
                <tr>
                    <th>Terakhir Diperbarui</th>
                    <td>{{ $kegiatan->updated_at->format('d M Y') }}</td>
                </tr>
            </table>

            {{-- 🔹 Tombol Aksi --}}
            <div class="text-end mt-3">
                <a href="{{ route('admin.kegiatan.index') }}" class="btn btn-secondary">
                    ⬅ Kembali
                </a>
                <a href="{{ route('admin.kegiatan.edit', $kegiatan->id) }}" class="btn btn-warning">
                    ✏ Edit
                </a>
            </div>
        </div>
    </div>
</div>

{{-- 🔹 Styling --}}
<style>
    .table th {
        width: 25%;
        background-color: #f8f9fa;
        vertical-align: middle;
    }

    .table td {
        background-color: #fff;
        padding: 1rem 1.25rem !important;
        vertical-align: top;
    }

    /* Quill content */
    .quill-content {
        font-size: 0.95rem;
        line-height: 1.6;
        color: #333;
        white-space: normal;
    }

    .quill-content p {
        margin-bottom: 0.75rem;
    }

    .quill-content ul,
    .quill-content ol {
        padding-left: 1.5rem;
        margin-bottom: 0.75rem;
    }

    .quill-content img {
        max-width: 100%;
        border-radius: 8px;
        margin: 0.5rem 0;
    }
</style>
@endsection
