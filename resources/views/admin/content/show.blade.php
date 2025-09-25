@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
        {{-- Header Card --}}
        <div class="card-header text-white" 
             style="background: linear-gradient(90deg, #14A09F, #5DC56B);">
            <h5 class="mb-0 fw-bold"><i class="bi bi-file-earmark-text me-2"></i> Detail Konten</h5>
        </div>

        {{-- Body --}}
        <div class="card-body">
            {{-- Judul --}}
            <div class="mb-4">
                <h6 class="fw-semibold">Judul</h6>
                <h3 class="fw-bold mb-2">{{ $content->title }}</h3>
            </div>

            {{-- Kategori --}}
            <div class="mb-4">
                <h6 class="fw-semibold">Kategori</h6>
                <span class="badge rounded-pill px-3 py-2" 
                      style="background: linear-gradient(90deg, #14A09F, #5DC56B);">
                    <i class="bi bi-folder2-open me-1"></i>
                    {{ $content->category->name ?? '-' }}
                </span>
            </div>

            {{-- Gambar --}}
            @if($content->images->count() > 0)
                <div class="mb-4">
                    <h6 class="fw-semibold">Gambar</h6>
                    <div class="row g-3">
                        @foreach($content->images as $img)
                            <div class="col-md-4 col-sm-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <img src="{{ asset('storage/' . $img->path) }}" 
                                         alt="Gambar"
                                         class="card-img-top rounded"
                                         style="object-fit:cover; height:200px;">
                                    <div class="card-body p-2 text-center">
                                        <small class="text-muted">
                                            {{ $img->caption ?? 'Tanpa keterangan' }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Deskripsi --}}
            <div class="mb-4">
                <h6 class="fw-semibold">Deskripsi</h6>
                <div class="ql-editor border rounded p-3 bg-white">
                    {!! $content->body !!}
                </div>
            </div>

            {{-- Info tambahan --}}
            <div class="text-muted small d-flex justify-content-between align-items-center">
                <span><i class="bi bi-person-circle me-1"></i> Administrator</span>
                <span><i class="bi bi-calendar3 me-1"></i> {{ $content->created_at->format('d M Y H:i') }}</span>
            </div>
        </div>

        {{-- Footer --}}
        <div class="card-footer bg-light d-flex justify-content-between">
            <a href="{{ route('admin.content.index') }}" class="btn btn-sm btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('admin.content.edit', $content->id) }}" class="btn btn-sm btn-gradient">
                <i class="bi bi-pencil-square"></i> Edit
            </a>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endpush
