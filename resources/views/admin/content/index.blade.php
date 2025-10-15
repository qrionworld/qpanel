@extends('layouts.admin')

@section('content')
<div class="container py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h2 class="fw-bold mb-0 text-gradient">📂 Daftar Blog</h2>
    </div>

    {{-- Search + Filter + Tambah Blog --}}
    <div class="d-flex justify-content-between align-items-center mb-3 gap-2 flex-wrap">
        <form method="GET" action="{{ route('admin.content.index') }}" 
              class="d-flex flex-grow-1 gap-2 flex-wrap flex-md-nowrap">

            {{-- Input search --}}
            <input type="text" name="search" 
                   class="form-control rounded-pill shadow-sm" 
                   placeholder="🔍 Cari blog..." 
                   value="{{ request('search') }}">

            {{-- Dropdown kategori --}}
            <select name="category" class="form-select rounded-pill shadow-sm min-w-150"
                    onchange="this.form.submit()">
                <option value="">-- Semua Kategori --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </form>

        {{-- Tombol tambah blog --}}
        <a href="{{ route('admin.content.create') }}" class="btn btn-success shadow-sm">
            + Tambah Blog
        </a>
    </div>

    {{-- Tabel content --}}
    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-gradient text-white">
                    <tr>
                        <th>#</th>
                        <th>Gambar</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Deskripsi</th>
                        <th>Dibuat</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contents as $index => $content)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>
                                @if($content->images->count() > 0)
                                    <img src="{{ asset('storage/' . $content->images->first()->path) }}" 
                                         alt="Thumbnail"
                                         class="rounded shadow-sm"
                                         style="width:60px; height:40px; object-fit:cover;">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $content->title }}</td>
                            <td>{{ $content->category->name ?? '-' }}</td>

                            {{-- Deskripsi dengan efek Quill dan tombol detail --}}
                            <td>
                                <div class="padding-top:10px; display:block" 
                                     style="max-height:70px; overflow:hidden; cursor:pointer;"
                                     data-bs-toggle="modal" 
                                     data-bs-target="#descModal"
                                     data-body="{{ e($content->body) }}">
                                    {{ Str::limit(strip_tags($content->body), 120) }}

                                </div>
                            </td>

                            <td>{{ $content->created_at->timezone('Asia/Jakarta')->translatedFormat('d M Y H:i') }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.content.show', $content->id) }}" class="btn btn-sm btn-info text-white shadow-sm">Detail</a>
                                <a href="{{ route('admin.content.edit', $content->id) }}" class="btn btn-sm btn-warning shadow-sm">Edit</a>
                                <form action="{{ route('admin.content.destroy', $content->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus konten ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger shadow-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada content</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="mt-3 px-3">
                {{ $contents->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

{{-- Modal Deskripsi Lengkap --}}
<div class="modal fade" id="descModal" tabindex="-1" aria-labelledby="descModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
          <div class="modal-header bg-gradient text-white" style="background: linear-gradient(90deg, #14A09F, #5DC56B);">
              <h5 class="modal-title" id="descModalLabel">Deskripsi Lengkap</h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body ql-editor" id="descContent" style="max-height: 70vh; overflow-y: auto;"></div>
      </div>
  </div>
</div>
@endsection

@push('styles')
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

.min-w-150 {
    min-width: 150px;
}

.table-gradient {
    background: linear-gradient(90deg, var(--teal), var(--green));
}

/* ✅ Perataan tabel & deskripsi */
.table td, .table th {
    vertical-align: middle !important;
}
.desc-cell p { margin: 0 !important; }
.desc-cell ul, .desc-cell ol { padding-left: 20px; margin: 0; }

/* Hover efek */
.desc-cell:hover {
    background: rgba(20, 160, 159, 0.05);
    border-radius: 6px;
}

/* Modal */
.modal-content {
    border-radius: 14px;
    box-shadow: 0 0 20px rgba(0,0,0,0.2);
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const descModal = document.getElementById('descModal');
    const descContent = document.getElementById('descContent');

    descModal.addEventListener('show.bs.modal', event => {
        const trigger = event.relatedTarget;
        const fullBody = trigger.getAttribute('data-body');
        descContent.innerHTML = decodeHTMLEntities(fullBody) || '<em>Tidak ada deskripsi</em>';
    });

    function decodeHTMLEntities(text) {
    var textarea = document.createElement('textarea');
    textarea.innerHTML = text;
    return textarea.value;
}
});
</script>
@endpush
