@extends('layouts.admin')

@section('title', 'Daftar Kegiatan')

@section('content')
<div class="container py-4">

    {{-- 🌟 Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h2 class="fw-bold mb-0 text-gradient">
            <i class="bi bi-calendar3 me-2"></i> Daftar Kegiatan
        </h2>
        <a href="{{ route('admin.kegiatan.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Tambah Kegiatan
        </a>
    </div>

    {{-- ✅ Alert Sukses --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- 📋 Tabel Daftar Kegiatan --}}
    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-gradient text-white text-center">
                    <tr>
                        <th width="15%">Foto</th>
                        <th width="20%">Judul</th>
                        <th width="30%">Deskripsi</th>
                        <th width="15%">Tanggal</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kegiatan as $item)
                        <tr>
                            {{-- 🖼️ Foto --}}
                            <td class="text-center">
                                @php $fotos = json_decode($item->foto, true); @endphp
                                @if (!empty($fotos) && is_array($fotos))
                                    <div class="d-flex justify-content-center flex-wrap gap-2">
                                        @foreach ($fotos as $foto)
                                            <img src="{{ asset('storage/' . $foto) }}" 
                                                 alt="Foto {{ $item->judul }}" 
                                                 class="rounded-3 shadow-sm"
                                                 style="width:80px; height:60px; object-fit:cover;">
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-muted fst-italic">Tidak ada</span>
                                @endif
                            </td>

                            {{-- 📌 Judul --}}
                            <td><strong>{{ $item->judul }}</strong></td>

                            {{-- 📝 Deskripsi --}}
                            <td class="text-muted text-truncate deskripsi-cell"
                                style="cursor:pointer; max-width:250px;"
                                data-bs-toggle="modal"
                                data-bs-target="#modalDeskripsi"
                                data-judul="{{ $item->judul }}"
                                data-deskripsi="{{ htmlentities($item->deskripsi) }}">
                                {!! Str::limit(strip_tags($item->deskripsi), 120) !!}
                                <div class="text-primary small fst-italic">Klik untuk lihat</div>
                            </td>

                            {{-- 📅 Tanggal --}}
                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}
                            </td>

                            {{-- ⚙️ Aksi --}}
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    <a href="{{ route('admin.kegiatan.show', $item->id) }}" 
                                       class="btn btn-sm btn-info text-white shadow-sm">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.kegiatan.edit', $item->id) }}" 
                                       class="btn btn-sm btn-warning text-dark shadow-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.kegiatan.destroy', $item->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger shadow-sm"
                                                onclick="return confirm('Yakin ingin menghapus kegiatan ini?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="bi bi-info-circle"></i> Belum ada kegiatan yang ditambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- 🔍 Modal Deskripsi --}}
<div class="modal fade" id="modalDeskripsi" tabindex="-1" aria-labelledby="modalDeskripsiLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-gradient text-white" 
                 style="background: linear-gradient(90deg, #14A09F, #5DC56B);">
                <h5 class="modal-title fw-bold" id="modalDeskripsiLabel">Deskripsi Kegiatan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalDeskripsiBody" style="max-height:70vh; overflow-y:auto;"></div>
        </div>
    </div>
</div>

{{-- 💡 Script --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modalBody = document.getElementById('modalDeskripsiBody');
        const modalTitle = document.getElementById('modalDeskripsiLabel');
        const deskripsiCells = document.querySelectorAll('.deskripsi-cell');

        deskripsiCells.forEach(cell => {
            cell.addEventListener('click', () => {
                modalTitle.innerText = cell.getAttribute('data-judul');
                modalBody.innerHTML = decodeHtml(cell.getAttribute('data-deskripsi'));
            });
        });

        function decodeHtml(html) {
            const txt = document.createElement("textarea");
            txt.innerHTML = html;
            return txt.value;
        }
    });
</script>
@endpush

{{-- 🎨 Style --}}
@push('styles')
<style>
    :root {
        --teal: #14A09F;
        --green: #5DC56B;
    }

    .text-gradient {
        background: linear-gradient(90deg, var(--teal), var(--green));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .table-gradient {
        background: linear-gradient(90deg, var(--teal), var(--green));
    }

    .table td, .table th {
        vertical-align: middle !important;
        text-align: center;
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
        transition: 0.2s ease-in-out;
    }

    .deskripsi-cell {
        text-align: left !important;
    }

    .deskripsi-cell:hover {
        background-color: #f0f8ff;
        transition: 0.2s;
    }

    .card {
        border-radius: 16px;
    }
</style>
@endpush
@endsection
