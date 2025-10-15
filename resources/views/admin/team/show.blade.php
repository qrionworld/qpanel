@extends('layouts.admin')

@section('title', 'Detail Team')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4">👥 Detail Anggota Team</h2>

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">
            <div class="mb-3 text-center">
                <img src="{{ asset('storage/' . $team->foto) }}" alt="Foto Team" class="rounded-circle" width="200">
            </div>

            <table class="table table-bordered">
                <tr>
                    <th>Nama</th>
                    <td>{{ $team->nama }}</td>
                </tr>
                <tr>
                    <th>Jabatan</th>
                    <td>{{ $team->jabatan }}</td>
                </tr>
                <tr>
                    <th>Deskripsi</th>
                    <td>{{ $team->deskripsi }}</td>
                </tr>
                <tr>
                    <th>Tanggal Ditambahkan</th>
                    <td>{{ $team->created_at->format('d M Y') }}</td>
                </tr>
            </table>

            <div class="text-end mt-3">
                <a href="{{ route('admin.team.index') }}" class="btn btn-secondary">⬅ Kembali</a>
                <a href="{{ route('admin.team.edit', $team->id) }}" class="btn btn-warning">✏ Edit</a>
            </div>
        </div>
    </div>
</div>
@endsection
