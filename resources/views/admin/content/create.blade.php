@extends('layouts.admin')

@section('title', 'Tambah Konten Baru')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">
            📝 Tambah Konten Baru
        </h2>
        <a href="{{ route('admin.content.index') }}" class="btn btn-secondary shadow-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- ✅ Form Tambah Konten --}}
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">
            <form id="contentForm" action="{{ route('admin.content.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Judul Konten --}}
                <div class="mb-3">
                    <label for="title" class="form-label fw-semibold">Judul Konten</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Masukkan judul konten" required>
                </div>

                {{-- Kategori Konten --}}
                <div class="mb-3">
                    <label for="category_id" class="form-label fw-semibold">Kategori</label>
                    <div class="input-group">
                        <select name="category_id" id="category_id" class="form-select" required>
                            <option value="" disabled selected>-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                            <option value="new">+ Tambah Kategori Baru</option>
                        </select>
                        <input type="text" id="new_category" name="new_category" class="form-control d-none" placeholder="Nama kategori baru">
                    </div>
                </div>

                {{-- Upload Gambar (Bisa lebih dari satu) --}}
                <div class="mb-3">
                    <label for="images" class="form-label fw-semibold">Gambar</label>
                    <input type="file" name="images[]" id="images" class="form-control" accept=".jpg,.jpeg,.png" multiple>
                    <small class="text-muted">Kamu bisa memilih lebih dari satu gambar (JPG, PNG, JPEG)</small>

                    {{-- Preview gambar --}}
                    <div id="preview-container" class="mt-2 d-flex flex-wrap gap-2"></div>
                </div>

                {{-- Deskripsi Konten (Quill Editor) --}}
                <div class="mb-3">
                    <label for="editor" class="form-label fw-semibold">Deskripsi Konten</label>
                    <div id="editor" style="height: 200px; background: #fff; border-radius: 8px;"></div>
                    <input type="hidden" name="body" id="body">
                </div>

                {{-- Tombol Simpan --}}
                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save"></i> Simpan Konten
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{-- ✅ Quill CSS & JS --}}
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

            // Simpan isi editor ke input hidden sebelum submit
            document.querySelector('#contentForm').addEventListener('submit', function () {
                document.querySelector('#body').value = quill.root.innerHTML;
            });

            // Dropdown kategori → tambah kategori baru
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

            // Preview gambar sebelum upload
            const imageInput = document.getElementById('images');
            const previewContainer = document.getElementById('preview-container');

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
