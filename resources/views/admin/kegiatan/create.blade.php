@extends('layouts.admin')

@section('title', 'Tambah Kegiatan')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4">➕ Tambah Kegiatan</h2>

    {{-- ✅ Form Tambah Kegiatan --}}
    <form 
        action="{{ route('admin.kegiatan.store') }}" 
        method="POST" 
        enctype="multipart/form-data" 
        class="card shadow-lg border-0 rounded-4 p-4"
        id="formKegiatan"
    >
        @csrf

        {{-- Judul --}}
        <div class="mb-3">
            <label class="fw-semibold">Judul</label>
            <input 
                type="text" 
                name="judul" 
                class="form-control" 
                placeholder="Masukkan judul kegiatan..." 
                required
            >
        </div>

        {{-- Deskripsi --}}
        <div class="mb-3">
            <label class="fw-semibold">Deskripsi</label>
            <div id="editor" style="height: 200px; background: #fff; border-radius: 8px;"></div>
            {{-- ❌ Tidak boleh pakai required di elemen tersembunyi --}}
            <textarea name="deskripsi" id="deskripsi" class="d-none"></textarea>
        </div>

        {{-- Tanggal --}}
        <div class="mb-3">
            <label class="fw-semibold">Tanggal</label>
            <input 
                type="date" 
                name="tanggal" 
                class="form-control" 
                required
            >
        </div>

        {{-- Foto --}}
        <div class="mb-3">
            <label class="fw-semibold">Foto</label>
            <input 
                type="file" 
                name="foto" 
                class="form-control"
                accept="image/*"
            >
        </div>

        {{-- Tombol --}}
        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-save me-1"></i> Simpan
            </button>
            <a href="{{ route('admin.kegiatan.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle me-1"></i> Kembali
            </a>
        </div>
    </form>
</div>

{{-- ✅ Quill CDN --}}
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

{{-- ✅ Inisialisasi Quill --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const quill = new Quill('#editor', {
            theme: 'snow',
            placeholder: 'Tulis deskripsi kegiatan di sini...',
            modules: {
                toolbar: [
                    [{ header: [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    ['link', 'image'],
                    ['clean']
                ]
            }
        });

        const form = document.getElementById('formKegiatan');

        form.addEventListener('submit', function (event) {
            const deskripsiField = document.getElementById('deskripsi');
            const editorContent = quill.root.innerHTML.trim();

            // ✅ Validasi manual untuk deskripsi kosong
            if (editorContent === '<p><br></p>' || editorContent === '') {
                event.preventDefault();
                alert('Deskripsi wajib diisi!');
                return false;
            }

            // ✅ Simpan isi Quill ke textarea sebelum dikirim
            deskripsiField.value = editorContent;
        });
    });
</script>

{{-- ✅ Styling tambahan --}}
<style>
    #editor {
        border: 1px solid #dee2e6;
        min-height: 200px;
    }
    .ql-toolbar.ql-snow {
        border-radius: 8px 8px 0 0;
    }
    .ql-container.ql-snow {
        border-radius: 0 0 8px 8px;
    }
</style>
@endsection
