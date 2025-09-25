<tbody>
    @forelse($contents as $index => $content)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>
                @if($content->images->count() > 0)
                    <img src="{{ asset('storage/' . $content->images->first()->path) }}" 
                         alt="Thumbnail" class="rounded shadow-sm"
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
            <td class="text-center d-flex justify-content-center gap-1">
                <a href="{{ route('admin.content.show', $content->id) }}" class="btn btn-sm btn-info text-white shadow-sm">Detail</a>
                <a href="{{ route('admin.content.edit', $content->id) }}" class="btn btn-sm btn-warning shadow-sm">Edit</a>
                <button type="button" class="btn btn-sm btn-danger shadow-sm"
                        data-bs-toggle="modal" 
                        data-bs-target="#deleteContentModal"
                        data-action="{{ route('admin.content.destroy', $content->id) }}">
                    Hapus
                </button>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center text-muted">Belum ada content</td>
        </tr>
    @endforelse
</tbody>
