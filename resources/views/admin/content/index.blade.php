@extends('layouts.admin')

@section('content')
<div class="container py-4">
    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h2 class="fw-bold mb-0">📚 <span class="text-gradient">Daftar Blog</span></h2>
        <a href="{{ route('admin.content.create') }}" class="btn btn-gradient px-4 shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Tambah Blog
        </a>
    </div>

    {{-- FILTER DAN PENCARIAN --}}
    <div class="card shadow border-0 glass-card rounded-4 mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.content.index') }}" 
                class="d-flex flex-wrap align-items-center gap-3 justify-content-between">

                <div class="d-flex flex-grow-1 gap-2 flex-wrap">
                    {{-- Input pencarian --}}
                    <div class="flex-grow-1">
                        <input type="text" name="search" 
                            class="form-control rounded-pill shadow-sm px-3" 
                            placeholder="🔍 Cari berdasarkan judul atau isi blog..." 
                            value="{{ request('search') }}">
                    </div>

                    {{-- Dropdown kategori --}}
                    <div>
                        <select name="category" class="form-select rounded-pill shadow-sm min-w-150"
                            onchange="this.form.submit()">
                            <option value="">-- Semua Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- TABEL BLOG --}}
    <div class="card shadow-lg border-0 rounded-4 overflow-hidden glass-card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-gradient text-white">
                    <tr>
                        <th class="text-center">#</th>
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
                        <tr class="table-row-hover">
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>
                                @if($content->images->count() > 0)
                                    <img src="{{ asset('storage/' . $content->images->first()->path) }}" 
                                         alt="Thumbnail"
                                         class="rounded-3 shadow-sm"
                                         style="width:65px; height:45px; object-fit:cover;">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="fw-semibold">{{ $content->title }}</td>
                            <td><span class="badge bg-gradient">{{ $content->category->name ?? '-' }}</span></td>

                            {{-- Deskripsi --}}
                            <td>
                                <div class="desc-preview" 
                                     data-bs-toggle="modal" 
                                     data-bs-target="#descModal"
                                     data-body="{{ e($content->body) }}">
                                    {{ Str::limit(strip_tags($content->body), 100) }}
                                </div>
                            </td>

                            <td>{{ $content->created_at->timezone('Asia/Jakarta')->translatedFormat('d M Y H:i') }}</td>

                            <td class="text-center">
                                <a href="{{ route('admin.content.show', $content->id) }}" class="btn btn-sm btn-info text-white shadow-sm">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.content.edit', $content->id) }}" class="btn btn-sm btn-warning shadow-sm text-white">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('admin.content.destroy', $content->id) }}" 
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus konten ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger shadow-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-emoji-frown fs-3 d-block mb-2"></i>
                                Belum ada blog yang ditambahkan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="mt-3 px-3 pb-3">
            {{ $contents->withQueryString()->links() }}
        </div>
    </div>
</div>

{{-- MODAL DESKRIPSI --}}
<div class="modal fade" id="descModal" tabindex="-1" aria-labelledby="descModalLabel" aria-hidden="true" 
     data-bs-backdrop="true" data-bs-keyboard="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
          <div class="modal-header text-white" style="background: linear-gradient(90deg, #14A09F, #5DC56B);">
              <h5 class="modal-title fw-semibold" id="descModalLabel">Deskripsi Lengkap</h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body ql-editor" id="descContent" style="max-height:70vh; overflow-y:auto; word-break:break-word;">
              <p class="text-muted">Memuat deskripsi...</p>
          </div>
      </div>
  </div>
</div>
@endsection


@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
:root {
    --teal: #14A09F;
    --green: #5DC56B;
}

/* --- HEADER TEXT --- */
.text-gradient {
    background: linear-gradient(90deg, var(--teal), var(--green));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* --- BUTTON STYLE --- */
.btn-gradient {
    background: linear-gradient(90deg, var(--teal), var(--green));
    border: none;
    color: white;
    transition: 0.3s ease;
}
.btn-gradient:hover {
    opacity: 0.9;
    transform: scale(1.03);
}

/* --- TABLE --- */
.table-gradient {
    background: linear-gradient(90deg, var(--teal), var(--green));
}
.table-row-hover:hover {
    background-color: rgba(20, 160, 159, 0.05);
    transition: 0.2s;
}

/* --- DESC PREVIEW --- */
.desc-preview {
    max-height: 70px;
    overflow: hidden;
    cursor: pointer;
    color: #444;
}
.desc-preview:hover {
    text-decoration: underline;
    color: var(--teal);
}

/* --- GLASS EFFECT CARD --- */
.glass-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
}

/* --- BADGE KATEGORI --- */
.bg-gradient {
    background: linear-gradient(90deg, var(--teal), var(--green)) !important;
}

/* --- PAGINATION --- */
.page-item.active .page-link {
    background: linear-gradient(90deg, var(--teal), var(--green));
    border: none;
}
.page-link {
    color: var(--teal);
}
.page-link:hover {
    background-color: rgba(20,160,159,0.1);
    color: var(--teal);
}
</style>
@endpush


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const descModal = document.getElementById('descModal');
    const descContent = document.getElementById('descContent');

    // Saat modal akan ditampilkan
    descModal.addEventListener('show.bs.modal', event => {
        const trigger = event.relatedTarget;
        if (!trigger) return;

        const fullBody = trigger.getAttribute('data-body') || '';
        descContent.innerHTML = decodeHTMLEntities(fullBody) || '<em>Tidak ada deskripsi</em>';
    });

    // Fungsi decode HTML entity
    function decodeHTMLEntities(text) {
        const textarea = document.createElement('textarea');
        textarea.innerHTML = text;
        return textarea.value;
    }

    // Setelah modal tampil, pastikan tampil di atas semua elemen
    descModal.addEventListener('shown.bs.modal', () => {
        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) backdrop.style.zIndex = 2000;
        descModal.style.zIndex = 2050;
        document.body.style.overflow = 'auto';
    });
});
</script>

<style>
/* ✅ Pastikan modal muncul paling atas */
.modal {
    z-index: 2050 !important;
}

/* ✅ Backdrop juga diperbaiki */
.modal-backdrop {
    z-index: 2000 !important;
}

/* ✅ Cegah elemen parent menutup modal */
.table-responsive,
.card,
.container {
    overflow: visible !important;
}
</style>
@endpush