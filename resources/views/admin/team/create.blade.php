@extends('layouts.admin')

@section('title', 'Tambah Team')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4">➕ Tambah Anggota Team</h2>

    <form action="{{ route('admin.team.store') }}" method="POST" enctype="multipart/form-data" class="card shadow-lg border-0 rounded-4 p-4">
        @csrf

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Jabatan</label>
            <input type="text" name="jabatan" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <div id="deskripsi-editor" style="height: 150px;"></div>
            <input type="hidden" name="deskripsi" id="deskripsi">
        </div>

        <div class="mb-3">
            <label>Foto</label>
            <input type="file" name="foto" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.team.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection

@push('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
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

    const form = document.querySelector('form');
    form.addEventListener('submit', function () {
        document.querySelector('#deskripsi').value = quill.root.innerHTML;
    });
});
</script>
@endpush
