@extends('layouts.admin')

@section('title', 'Edit Kegiatan')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4">✏️ Edit Kegiatan</h2>

    <form 
        action="{{ route('admin.kegiatan.update', $kegiatan->id) }}" 
        method="POST" 
        enctype="multipart/form-data"
        class="card shadow-lg border-0 rounded-4 p-4"
        id="formEditKegiatan"
    >
        @csrf
        @method('PUT')

        {{-- Judul --}}
        <div class="mb-3">
            <label class="fw-semibold">Judul</label>
            <input 
                type="text" 
                name="judul" 
                value="{{ old('judul', $kegiatan->judul) }}" 
                class="form-control" 
                required
            >
        </div>

        {{-- Deskripsi --}}
        <div class="mb-3">
            <label class="fw-semibold">Deskripsi</label>
            <div id="editor" style="height: 200px; background: #fff; border-radius: 8px;"></div>
            <textarea name="deskripsi" id="deskripsi" class="d-none"></textarea>
        </div>

        {{-- Tanggal --}}
        <div class="mb-3">
            <label class="fw-semibold">Tanggal</label>
            <input 
                type="date" 
                name="tanggal" 
                value="{{ old('tanggal', $kegiatan->tanggal) }}" 
                class="form-control" 
                required
            >
        </div>

        {{-- Foto --}}
        <div class="mb-3">
            <label class="fw-semibold">Foto Kegiatan</label><br>

            {{-- Tampilkan foto lama --}}
            @if($kegiatan->foto)
                <div class="mb-2 d-flex flex-wrap gap-2">
                    @foreach(json_decode($kegiatan->foto, true) ?? [] as $foto)
                        <img src="{{ asset('storage/' . $foto) }}" width="100" class="rounded shadow-sm">
                    @endforeach
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" name="hapus_foto" id="hapus_foto" class="form-check-input">
                    <label for="hapus_foto" class="form-check-label">Hapus semua foto lama</label>
                </div>
            @endif

            {{-- Upload multiple foto baru --}}
            <input type="file" name="foto[]" id="foto" class="form-control" accept="image/*" multiple>
            <small class="text-muted">Dapat mengunggah lebih dari 1 gambar (maks 2MB per gambar)</small>

            {{-- Preview gambar baru --}}
            <div id="preview" class="mt-3 d-flex flex-wrap gap-2"></div>
        </div>

        {{-- Tombol --}}
        <div class="d-flex gap-2 mt-4">
            <button class="btn btn-primary">💾 Update</button>
            <a href="{{ route('admin.kegiatan.index') }}" class="btn btn-secondary">⬅️ Kembali</a>
        </div>
    </form>
</div>

{{-- ✅ Quill --}}
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const quill = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'Tulis atau ubah deskripsi kegiatan di sini...',
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

    // ✅ Muat isi lama dari database
    const oldContent = @json($kegiatan->deskripsi ?? '');
    quill.root.innerHTML = oldContent;

    // ✅ Validasi & preview multiple image
    const fileInput = document.getElementById('foto');
    const preview = document.getElementById('preview');
    const MAX_SIZE_MB = 2;

    fileInput.addEventListener('change', function () {
        preview.innerHTML = "";
        const files = Array.from(this.files);

        for (const file of files) {
            if (file.size > MAX_SIZE_MB * 1024 * 1024) {
                alert(`⚠️ ${file.name} terlalu besar (${(file.size / 1024 / 1024).toFixed(2)} MB). Maksimal ${MAX_SIZE_MB} MB.`);
                this.value = "";
                preview.innerHTML = "";
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('rounded', 'shadow-sm');
                img.style.width = '100px';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    });

    // ✅ Saat form disubmit
    const form = document.getElementById('formEditKegiatan');
    form.addEventListener('submit', function (e) {
        const deskripsiField = document.getElementById('deskripsi');
        const editorContent = quill.root.innerHTML.trim();

        if (editorContent === '<p><br></p>' || editorContent === '') {
            e.preventDefault();
            alert('Deskripsi wajib diisi!');
            return false;
        }

        deskripsiField.value = editorContent;
    });
});
</script>

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
