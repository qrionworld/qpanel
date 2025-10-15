@extends('layouts.admin')

@section('title', 'Edit Team')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4">✏️ Edit Anggota Team</h2>

    <form action="{{ route('admin.team.update', $team->id) }}" method="POST" enctype="multipart/form-data" class="card shadow-lg border-0 rounded-4 p-4">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" value="{{ $team->nama }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Jabatan</label>
            <input type="text" name="jabatan" value="{{ $team->jabatan }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            {{-- ✅ Quill Editor --}}
            <div id="deskripsi-editor" style="height: 150px;">{!! $team->deskripsi !!}</div>
            <input type="hidden" name="deskripsi" id="deskripsi">
        </div>

        <div class="mb-3">
            <label>Foto</label><br>
            @if($team->foto)
                <img src="{{ asset('storage/' . $team->foto) }}" alt="Foto" width="100" class="rounded mb-2">
            @endif
            <input type="file" name="foto" class="form-control">
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('admin.team.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection

{{-- ✅ Tambahkan Quill CSS --}}
@push('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endpush

{{-- ✅ Tambahkan Quill JS --}}
@push('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    // ✅ Inisialisasi Quill Editor
    var quill = new Quill('#deskripsi-editor', {
        theme: 'snow',
        placeholder: 'Tulis deskripsi anggota di sini...',
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

    // ✅ Set nilai awal (dari database)
    document.addEventListener('DOMContentLoaded', function () {
        const deskripsiHidden = document.querySelector('#deskripsi');
        deskripsiHidden.value = quill.root.innerHTML;
    });

    // ✅ Simpan isi editor ke input hidden sebelum submit
    document.querySelector('form').onsubmit = function() {
        document.querySelector('#deskripsi').value = quill.root.innerHTML;
    };
</script>
@endpush
