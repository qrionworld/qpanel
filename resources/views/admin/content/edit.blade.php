@extends('layouts.admin')

@section('title', 'Edit Konten')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">✏️ Edit Konten</h2>
        <a href="{{ route('admin.content.index') }}" class="btn btn-secondary shadow-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger rounded-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">
            <form id="contentForm"
                  action="{{ route('admin.content.update', $content->id) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Judul --}}
                <div class="mb-3">
                    <label for="title" class="form-label fw-semibold">Judul</label>
                    <input type="text" name="title" id="title" class="form-control"
                           value="{{ old('title', $content->title) }}" required>
                </div>

                {{-- Kategori --}}
                <div class="mb-3">
                    <label for="category_id" class="form-label fw-semibold">Kategori</label>
                    <div class="input-group">
                        <select name="category_id" id="category_id" class="form-select" required>
                            <option value="" disabled>-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ old('category_id', $content->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                            <option value="new">+ Tambah Kategori Baru</option>
                        </select>

                        <input type="text" name="new_category" id="new_category"
                               class="form-control d-none"
                               placeholder="Nama kategori baru"
                               value="{{ old('new_category') }}">
                    </div>
                    <small class="text-muted">Pilih kategori lama atau tambahkan kategori baru.</small>
                </div>

                {{-- Deskripsi pakai Quill --}}
                <div class="mb-3">
                    <label for="editor" class="form-label fw-semibold">Deskripsi Konten</label>
                    <div id="editor" style="height:200px; background:#fff; border-radius:8px;">
                        {!! old('body', $content->body) !!}
                    </div>
                    <input type="hidden" name="body" id="body">
                </div>

                {{-- Upload Gambar Baru --}}
                <div class="mb-3">
                    <label for="images" class="form-label fw-semibold">Upload Gambar Baru</label>
                    <input type="file" name="images[]" id="images" class="form-control" multiple accept="image/*">
                    <small class="text-muted">Kamu bisa memilih lebih dari satu gambar.</small>

                    {{-- Preview gambar baru --}}
                    <div id="preview" class="d-flex flex-wrap gap-2 mt-2"></div>
                </div>

                {{-- Gambar Lama --}}
                @if ($content->images->count() > 0)
                <div class="mb-3">
                    <label class="form-label fw-semibold">Gambar Lama</label>
                    <div class="d-flex flex-wrap gap-3">
                        @foreach($content->images as $img)
                            <div class="text-center">
                                <img src="{{ asset('storage/' . $img->path) }}"
                                     class="rounded shadow-sm mb-1"
                                     style="width: 100px; height: 80px; object-fit: cover;">
                                <div>
                                    <input type="checkbox" name="delete_images[]" value="{{ $img->id }}">
                                    <small>Hapus</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Tombol --}}
                <div class="text-end">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-save"></i> Update Konten
                    </button>
                    <a href="{{ route('admin.content.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // 🔹 Inisialisasi Quill
    var quill = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'Edit deskripsi konten...',
        modules: {
            toolbar: {
                container: [
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    ['link', 'image'] // ← Tambahkan tombol image di toolbar
                ],
                handlers: {
                    image: imageHandler // ← Tambahkan handler custom
                }
            }
        }
    });

    // 🔹 Handler untuk tombol gambar
    function imageHandler() {
        const input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');
        input.click();

        input.onchange = () => {
            const file = input.files[0];
            if (/^image\//.test(file.type)) {
                const reader = new FileReader();
                reader.onload = () => {
                    const range = quill.getSelection();
                    quill.insertEmbed(range.index, 'image', reader.result);
                };
                reader.readAsDataURL(file);
            } else {
                alert('Harap pilih file gambar yang valid.');
            }
        };
    }

    // 🔹 Saat form disubmit → simpan HTML hasil Quill ke hidden input
    document.querySelector('#contentForm').addEventListener('submit', function() {
        document.querySelector('#body').value = quill.root.innerHTML;
    });

    // 🔹 Toggle kategori lama / baru
    const newCategory = document.getElementById('new_category');
    const categorySelect = document.getElementById('category');
    newCategory.addEventListener('input', function () {
        categorySelect.disabled = this.value.trim() !== "";
    });
});


    // ✅ Dropdown kategori → input kategori baru
    const categorySelect = document.getElementById('category_id');
    const newCategoryInput = document.getElementById('new_category');

    categorySelect.addEventListener('change', function() {
        if (this.value === 'new') {
            newCategoryInput.classList.remove('d-none');
            newCategoryInput.required = true;
        } else {
            newCategoryInput.classList.add('d-none');
            newCategoryInput.required = false;
            newCategoryInput.value = '';
        }
    });

    // ✅ Preview gambar baru
    const imageInput = document.getElementById('images');
    const previewContainer = document.getElementById('preview');

    imageInput.addEventListener('change', function() {
        previewContainer.innerHTML = '';
        Array.from(this.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('rounded', 'shadow-sm');
                img.style.width = '100px';
                img.style.height = '100px';
                img.style.objectFit = 'cover';
                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });

</script>
@endpush
