@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Tambah Konten</h1>

    {{-- Error Alert --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Tambah Konten --}}
    <form id="contentForm" action="{{ route('admin.content.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Judul --}}
        <div class="mb-3">
            <label for="title" class="form-label">Judul</label>
            <input 
                type="text" 
                name="title" 
                id="title"
                class="form-control"
                value="{{ old('title') }}"
                required
            >
        </div>

        {{-- Kategori --}}
        <div class="mb-3">
            <label for="category" class="form-label">Kategori</label>
            <input 
                list="categories" 
                name="category" 
                id="category" 
                class="form-control" 
                value="{{ old('category') }}"
                placeholder="Pilih atau ketik kategori baru"
                required
            >
            <datalist id="categories">
                @foreach($categories as $cat)
                    <option value="{{ $cat }}"></option>
                @endforeach
            </datalist>
        </div>

        {{-- Deskripsi pakai Quill --}}
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <div id="editor" style="height:200px; background:#fff;">
                {!! old('body') !!}
            </div>
            <input type="hidden" name="body" id="body">
        </div>

        {{-- Upload Gambar --}}
        <div class="mb-3">
            <label for="images" class="form-label">Upload Gambar</label>
            <input 
                type="file" 
                name="images[]" 
                id="images" 
                class="form-control" 
                multiple
            >
            <small class="text-muted">Bisa pilih lebih dari satu gambar.</small>
        </div>

        {{-- Action Buttons --}}
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.content.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

@section('scripts')
    {{-- Quill CSS & JS --}}
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

    <script>
        // Init Quill
        var quill = new Quill('#editor', {
            theme: 'snow',
            placeholder: 'Tulis deskripsi konten di sini...',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    ['link']
                ]
            }
        });

        // Masukkan isi Quill ke input hidden saat submit
        document.querySelector('#contentForm').addEventListener('submit', function () {
            document.querySelector('#body').value = quill.root.innerHTML;
        });
    </script>
@endsection
