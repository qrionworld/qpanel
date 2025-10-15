@extends('layouts.admin')

@section('title', 'Daftar Team')

@section('content')
 
<div class="container py-4">

    {{-- 🔹 Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h2 class="fw-bold mb-0 text-gradient">
            <i class="bi bi-people-fill me-2"></i> Daftar Team
        </h2>
        <a href="{{ route('admin.team.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-person-plus me-1"></i> Tambah Anggota
        </a>
    </div>

    {{-- 🔹 Alert sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- 🔹 Card tabel --}}
    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-center">
                <thead class="table-gradient text-white">
                    <tr>
                        <th width="10%">Foto</th>
                        <th width="25%">Nama</th>
                        <th width="20%">Jabatan</th>
                        <th width="30%">Deskripsi</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($teams as $team)
                        <tr>
                            {{-- Foto --}}
                            <td>
                                @if($team->foto)
                                    <img src="{{ asset('storage/' . $team->foto) }}" 
                                         alt="Foto {{ $team->nama }}" 
                                         class="rounded-circle shadow-sm"
                                         style="width:60px; height:60px; object-fit:cover;">
                                @else
                                    <span class="text-muted fst-italic">Tidak ada</span>
                                @endif
                            </td>

                            {{-- Nama --}}
                            <td class="fw-semibold align-middle">{{ $team->nama }}</td>

                            {{-- Jabatan --}}
                            <td class="text-muted align-middle">{{ $team->jabatan }}</td>

                            {{-- Deskripsi --}}
                            <td class="text-muted align-middle text-start deskripsi-cell"
                                style="cursor:pointer;"
                                data-bs-toggle="modal"
                                data-bs-target="#modalDeskripsi"
                                data-nama="{{ $team->nama }}"
                                data-deskripsi="{!! htmlspecialchars($team->deskripsi, ENT_QUOTES) !!}"
                                {!! Str::limit(strip_tags($team->deskripsi), 80, '...') !!}
                                <div class="text-primary small fst-italic">Klik untuk lihat</div>
                            </td>

                            {{-- Aksi --}}
                            <td class="align-middle">
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    <a href="{{ route('admin.team.show', $team->id) }}" 
                                       class="btn btn-sm btn-info text-white shadow-sm d-flex align-items-center gap-1">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                    <a href="{{ route('admin.team.edit', $team->id) }}" 
                                       class="btn btn-sm btn-warning text-dark shadow-sm d-flex align-items-center gap-1">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.team.destroy', $team->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger shadow-sm d-flex align-items-center gap-1"
                                                onclick="return confirm('Yakin ingin menghapus anggota ini?')">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="bi bi-info-circle"></i> Belum ada anggota team yang ditambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- 🔹 Modal Deskripsi --}}
<div class="modal fade" id="modalDeskripsi" tabindex="-1" aria-labelledby="modalDeskripsiLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-gradient text-white" style="background: linear-gradient(90deg, #14A09F, #5DC56B);">
                <h5 class="modal-title fw-bold" id="modalDeskripsiLabel">Deskripsi Anggota</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalDeskripsiBody" style="max-height:70vh; overflow-y:auto;">
                {{-- Konten akan diisi lewat JS --}}
            </div>
        </div>
    </div>
</div>

{{-- 🔹 Script Modal --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const modalBody = document.getElementById('modalDeskripsiBody');
    const modalTitle = document.getElementById('modalDeskripsiLabel');

    document.querySelectorAll('.deskripsi-cell').forEach(cell => {
        cell.addEventListener('click', () => {
            const nama = cell.dataset.nama;
            const deskripsi = cell.dataset.deskripsi;
            modalTitle.innerText = `Deskripsi - ${nama}`;
            modalBody.innerHTML = decodeHtml(deskripsi);
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

{{-- 🔹 Styling tambahan --}}
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

    th, td {
        vertical-align: middle !important;
    }

    .deskripsi-cell:hover {
        background-color: #f8f9fa;
        transition: 0.2s;
    }

    .modal-body {
        font-size: 0.95rem;
        line-height: 1.6;
        color: #333;
    }

    .modal-body img {
        max-width: 100%;
        border-radius: 8px;
        margin: 0.5rem 0;
    }
</style>
@endpush
@endsection
