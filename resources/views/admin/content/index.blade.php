@extends('layouts.admin')

@section('content')
<div class="container py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h2 class="fw-bold mb-0 text-gradient">📂 Daftar Blog</h2>

        <div class="d-flex gap-2 flex-wrap">
            {{-- 🔍 Filter Kategori --}}
            <form method="GET" action="{{ route('admin.content.index') }}">
                <select name="category" class="form-select d-inline w-auto shadow-sm rounded-pill" onchange="this.form.submit()">
                    <option value="">-- Semua Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </form>

            {{-- Tombol tambah content --}}
            <a href="{{ route('admin.content.create') }}" class="btn btn-gradient shadow-sm">
                + Tambah Blog
            </a>
        </div>
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
                            <td>{{ $content->created_at->format('d M Y H:i') }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.content.show', $content->id) }}" class="btn btn-sm btn-info text-white shadow-sm">
                                    Detail
                                </a>
                                <a href="{{ route('admin.content.edit', $content->id) }}" class="btn btn-sm btn-warning shadow-sm">
                                    Edit
                                </a>
                                <form action="{{ route('admin.content.destroy', $content->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin mau hapus konten ini?')">
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
    {{-- Quill CSS supaya hasil deskripsi mirip editor --}}
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <style>
        :root {
            --teal: #14A09F;
            --green: #5DC56B;
        }

        /* Gradient text */
        .text-gradient {
            background: linear-gradient(90deg, var(--teal), var(--green));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Gradient button */
        .btn-gradient {
            background: linear-gradient(90deg, var(--teal), var(--green));
            border: none;
            border-radius: 30px;
            padding: 8px 20px;
            color: #fff !important;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-gradient:hover {
            background: linear-gradient(90deg, var(--green), var(--teal));
            transform: translateY(-2px);
        }

        /* Table header gradient */
        .table-gradient {
            background: linear-gradient(90deg, var(--teal), var(--green));
        }

        /* Card modern style */
        .card {
            border-radius: 16px;
        }
    </style>
@endpush
