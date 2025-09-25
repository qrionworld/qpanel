<div class="row g-4">
    @forelse($contents as $content)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden card-hover">
                
                {{-- Gambar thumbnail --}}
                @if($content->images->count())
                    <img src="{{ asset('storage/' . $content->images->first()->path) }}" 
                         class="card-img-top" style="height:180px; object-fit:cover;">
                @endif

                <div class="card-body d-flex flex-column">
                    {{-- Judul --}}
                    <h5 class="card-title">{{ $content->title }}</h5>

                    {{-- Kategori --}}
                    <span class="badge bg-info mb-2">{{ $content->category->name ?? '-' }}</span>

                    {{-- Ringkasan --}}
                    <p class="card-text text-muted" style="flex-grow:1;">{!! Str::limit($content->body, 100) !!}</p>

                    {{-- Tanggal --}}
                    <small class="text-muted mb-2">{{ $content->created_at->format('d M Y H:i') }}</small>

                    {{-- Tombol aksi --}}
                    <div class="mt-auto d-flex gap-2 flex-wrap">
                        <a href="{{ route('admin.content.show', $content->id) }}" class="btn btn-sm btn-info flex-grow-1">Detail</a>
                        <a href="{{ route('admin.content.edit', $content->id) }}" class="btn btn-sm btn-warning flex-grow-1">Edit</a>

                        <form action="{{ route('admin.content.destroy', $content->id) }}" method="POST" class="d-inline flex-grow-1"
                              onsubmit="return confirm('Yakin mau hapus konten ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger w-100">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center text-muted">
            Belum ada content
        </div>
    @endforelse
</div>

{{-- Pagination --}}
<div class="mt-3">
    {{ $contents->withQueryString()->links() }}
</div>
