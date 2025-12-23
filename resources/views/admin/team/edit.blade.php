@extends('layouts.admin')

@section('title', 'Edit Team')

@section('content')
<div class="container py-4">

    {{-- 🔹 Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h2 class="fw-bold mb-0 text-gradient">
            <i class="bi bi-pencil-square me-2"></i> Edit Anggota Team
        </h2>
        <a href="{{ route('admin.team.index') }}" class="btn btn-outline-secondary shadow-sm rounded-pill px-3">
            <i class="bi bi-arrow-left-circle me-1"></i> Kembali
        </a>
    </div>

    {{-- 🔹 Card Form --}}
    <div class="card shadow-lg border-0 rounded-4 p-4 bg-white">
        <form action="{{ route('admin.team.update', $team->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div class="mb-4">
                <label class="form-label fw-semibold text-secondary">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ $team->nama }}" class="form-control form-control-lg rounded-3 shadow-sm" placeholder="Masukkan nama anggota" required>
            </div>

            {{-- Jabatan --}}
            <div class="mb-4">
                <label class="form-label fw-semibold text-secondary">Jabatan</label>
                <input type="text" name="jabatan" value="{{ $team->jabatan }}" class="form-control form-control-lg rounded-3 shadow-sm" placeholder="Masukkan jabatan anggota" required>
            </div>

            {{-- Deskripsi --}}
            <div class="mb-4">
                <label class="form-label fw-semibold text-secondary">Deskripsi</label>
                <div id="deskripsi-editor" class="rounded-3 shadow-sm" style="height: 200px;">{!! $team->deskripsi !!}</div>
                <input type="hidden" name="deskripsi" id="deskripsi">
            </div>

            {{-- Foto --}}
            <div class="mb-4">
                <label class="form-label fw-semibold text-secondary">Foto Anggota</label>
                @if($team->foto)
                    <div class="mb-3">
                        <img id="preview" src="{{ asset('storage/' . $team->foto) }}" alt="Foto Anggota" class="rounded-4 shadow-sm" width="120" height="120" style="object-fit: cover;">
                    </div>
                @else
                    <img id="preview" src="https://via.placeholder.com/120x120?text=Preview" alt="Preview" class="rounded-4 shadow-sm mb-3" width="120" height="120">
                @endif
                <input type="file" name="foto" id="fotoInput" class="form-control form-control-lg rounded-3 shadow-sm">
                <small class="text-muted fst-italic">Format: JPG, PNG, JPEG (maksimal 2MB)</small>
            </div>

            {{-- Tombol Aksi --}}
            <div class="d-flex justify-content-end mt-4 gap-3">
                <button type="reset" class="btn btn-outline-secondary px-4 py-2 rounded-pill shadow-sm">
                    <i class="bi bi-arrow-repeat me-1"></i> Reset
                </button>
                <button type="submit" class="btn btn-success px-4 py-2 rounded-pill shadow-sm">
                    <i class="bi bi-save me-1"></i> Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
{{-- Quill Editor --}}
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

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

    .form-label {
        font-size: 1rem;
    }

    .form-control-lg {
        font-size: 1rem;
        padding: 0.7rem 1rem;
        border: 1px solid #dee2e6;
        transition: all 0.2s ease-in-out;
    }

    .form-control-lg:focus {
        border-color: var(--teal);
        box-shadow: 0 0 0 0.2rem rgba(20, 160, 159, 0.25);
    }

    .ql-toolbar {
        border-radius: 10px 10px 0 0;
        background-color: #f8f9fa;
    }

    .ql-container {
        border-radius: 0 0 10px 10px;
    }

    .btn-success {
        background: linear-gradient(90deg, var(--teal), var(--green));
        border: none;
    }

    .btn-success:hover {
        opacity: 0.9;
    }

    .shadow-sm {
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06) !important;
    }
</style>
@endpush

@push('scripts')
{{-- Quill JS --}}
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ✅ Inisialisasi Quill
    const quill = new Quill('#deskripsi-editor', {
        theme: 'snow',
        placeholder: 'Tulis deskripsi atau tanggung jawab anggota di sini...',
        modules: {
            toolbar: [
                [{ header: [1, 2, false] }],
                ['bold', 'italic', 'underline'],
                ['link', 'blockquote', 'code-block'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                ['clean']
            ]
        }
    });

    // ✅ Set nilai awal deskripsi
    const hiddenInput = document.querySelector('#deskripsi');
    hiddenInput.value = quill.root.innerHTML;

    // ✅ Update isi sebelum submit
    document.querySelector('form').addEventListener('submit', function () {
        hiddenInput.value = quill.root.innerHTML;
    });

    // ✅ Preview Foto otomatis
    const fotoInput = document.getElementById('fotoInput');
    const preview = document.getElementById('preview');
    fotoInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            preview.src = URL.createObjectURL(file);
        }
    });
});
</script>
@endpush
