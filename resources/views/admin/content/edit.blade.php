@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4">Edit Konten</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="contentForm" 
          action="{{ route('admin.content.update', $content->id) }}" 
          method="POST" 
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Judul --}}
        <div class="mb-3">
            <label for="title" class="form-label">Judul</label>
            <input type="text" name="title" id="title"
                   class="form-control"
                   value="{{ old('title', $content->title) }}"
                   required>
        </div>

        {{-- Kategori --}}
        <div class="mb-3">
            <label for="category" class="form-label">Kategori</label>
            <input list="categories" name="category" id="category" 
                   class="form-control" 
                   value="{{ old('category', $content->category->name ?? '') }}"
                   required>
            <datalist id="categories">
                @foreach($categories as $cat)
                    <option value="{{ $cat }}"></option>
                @endforeach
            </datalist>
        </div>

        {{-- Deskripsi pakai Quill --}}
        <div class="mb-3">
            <label for="body" class="form-label">Deskripsi</label>
            <div id="editor" style="height:200px; background:#fff;">{!! old('body', $content->body) !!}</div>
            <input type="hidden" name="body" id="body">
        </div>

        {{-- Upload Gambar Baru --}}
<div class="mb-3">
    <label for="images" class="form-label">Upload Gambar Baru</label>
    <input type="file" name="images[]" id="images" class="form-control" multiple accept="image/*">
    <small class="text-muted">Bisa pilih lebih dari satu gambar.</small>

    {{-- Preview Gambar Baru --}}
    <div id="preview" class="d-flex gap-3 flex-wrap mt-3"></div>
</div>

        {{-- Preview Gambar Lama --}}
        {{-- Gambar Lama --}}
<div class="mb-3">
    <label class="form-label">Gambar Lama</label>
    <div class="d-flex gap-3 flex-wrap">
        @foreach($content->images as $img)
            <div class="text-center">
                <img src="{{ asset('storage/' . $img->path) }}" 
                     alt="Gambar lama"
                     class="rounded mb-1"
                     style="width:100px; height:70px; object-fit:cover;">
                <div>
                    <input type="checkbox" name="delete_images[]" value="{{ $img->id }}">
                    <small>Hapus</small>
                </div>
            </div>
        @endforeach
    </div>
</div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('admin.content.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

@section('scripts')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
    var quill = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'Edit deskripsi konten...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                ['link']
            ]
        }
    });

    document.querySelector('#contentForm').addEventListener('submit', function() {
        document.querySelector('#body').value = quill.root.innerHTML;
    });
</script>
@endsection
