<form action="{{ route('categories.store') }}" method="POST" class="mb-3">
    @csrf
    <input type="text" name="name" placeholder="Nama Kategori" required>
    <button type="submit" class="btn btn-primary">Tambah Kategori</button>
</form>

<ul>
    @foreach($categories as $category)
        <li>{{ $category->name }}</li>
    @endforeach
</ul>
