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
                            <td>{{ $index + 1 }}</td>
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
                            <td>
                                <div class="ql-editor small" style="max-height:70px; overflow:hidden;">
                                    {!! Str::limit($content->body, 120) !!}
                                </div>
                            </td>
                            <td>{{ $content->created_at->timezone('Asia/Jakarta')->translatedFormat('d M Y H:i') }}</td>

                            <td class="text-center">
                                <a href="{{ route('admin.content.show', $content->id) }}" class="btn btn-sm btn-info text-white shadow-sm">Detail</a>
                                <a href="{{ route('admin.content.edit', $content->id) }}" class="btn btn-sm btn-warning shadow-sm">Edit</a>

                                {{-- Form DELETE langsung --}}
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
.card {
    border-radius: 16px;
}
</style>
@endpush
