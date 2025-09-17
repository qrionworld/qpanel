{{-- resources/views/admin/settings.blade.php --}}
@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">
        <i class="fas fa-cog"></i> Settings
    </h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <th><i class="fas fa-table"></i> App Name</th>
                    <td>{{ $settings->app_name ?? 'Qrion-app' }}</td>
                </tr>
                <tr>
                    <th><i class="fas fa-envelope"></i> Admin Email</th>
                    <td>{{ $settings->admin_email ?? 'ranggaafrn21@gmail.com' }}</td>
                </tr>
                <tr>
                    <th><i class="fas fa-adjust"></i> Theme</th>
                    <td>{{ $settings->theme ?? 'Light' }}</td>
                </tr>
                <tr>
                    <th><i class="fas fa-tag"></i> App Version</th>
                    <td>{{ $settings->app_version ?? 'v1.9.2' }}</td>
                </tr>
            </table>

            <div class="text-end">
                <a href="{{ route('admin.settings.edit') }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit Settings
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
