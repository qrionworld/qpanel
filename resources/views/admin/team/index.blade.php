@extends('layouts.admin')

@section('title', 'Daftar Team')

@section('content')
<div class="container py-4">

    {{-- 🔹 Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h2 class="fw-bold mb-0 text-gradient">
            <i class="bi bi-people-fill me-2 text-primary"></i> Daftar Team
        </h2>
        <a href="{{ route('admin.team.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-person-plus me-1"></i> Tambah Anggota
        </a>
    </div>

    {{-- 🔹 Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- 🔹 Tabel Team --}}
    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-gradient text-white text-center">
                    <tr>
                        <th style="width: 15%;">Foto</th>
                        <th style="width: 20%;">Nama</th>
                        <th style="width: 20%;">Jabatan</th>
                        <th style="width: 30%;">Deskripsi</th>
                        <th style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($teams as $team)
                        <tr>
                            {{-- Foto --}}
                            <td class="text-center">
                                @if($team->foto)
                                    <img src="{{ asset('storage/' . $team->foto) }}" 
                                         alt="Foto {{ $team->nama }}" 
                                         class="rounded-3 shadow-sm"
                                         style="width:80px; height:60px; object-fit:cover;">
                                @else
                                    <span class="text-muted fst-italic">Tidak ada</span>
                                @endif
                            </td>

                            {{-- Nama --}}
                            <td><strong>{{ $team->nama }}</strong></td>

                            {{-- Jabatan --}}
                            <td class="text-muted">{{ $team->jabatan }}</td>

                            {{-- Deskripsi --}}
                            <td class="text-muted text-truncate deskripsi-cell"
                                style="cursor:pointer; max-width:250px;"
                                data-bs-toggle="modal"
                                data-bs-target="#modalDeskripsi"
                                data-nama="{{ $team->nama }}"
                                data-deskripsi="{{ htmlentities($team->deskripsi) }}">
                                {!! Str::limit(strip_tags($team->deskripsi), 100) !!}
                                <div class="text-primary small fst-italic">Klik untuk lihat</div>
                            </td>

                            {{-- Aksi --}}
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    <a href="{{ route('admin.team.show', $team->id) }}" 
                                       class="btn btn-sm btn-info text-white shadow-sm">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.team.edit', $team->id) }}" 
                                       class="btn btn-sm btn-warning text-dark shadow-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.team.destroy', $team->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger shadow-sm"
                                                onclick="return confirm('Yakin ingin menghapus anggota ini?')">
                                            <i class="bi bi-trash"></i>
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
                {{-- Konten dinamis dari JS --}}
            </div>
        </div>
    </div>
</div>

{{-- 🔹 Script --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modalBody = document.getElementById('modalDeskripsiBody');
        const modalTitle = document.getElementById('modalDeskripsiLabel');
        const deskripsiCells = document.querySelectorAll('.deskripsi-cell');

        deskripsiCells.forEach(cell => {
            cell.addEventListener('click', () => {
                const nama = cell.getAttribute('data-nama');
                const deskripsi = cell.getAttribute('data-deskripsi');

                modalTitle.innerText = nama;
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

{{-- 🔹 Style --}}
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

    .table td {
        padding: 0.9rem 1rem !important;
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
        transition: background-color 0.2s ease-in-out;
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

    .btn-info {
        background-color: #0dcaf0;
        border: none;
    }

    .btn-warning {
        background-color: #ffc107;
        border: none;
    }

    .btn-danger {
        background-color: #dc3545;
        border: none;
    }
</style>
@endpush
@endsection
