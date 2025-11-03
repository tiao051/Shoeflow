@extends('layouts.admin')

@section('title', 'Manage Categories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Categories</h2>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Add Category
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories['data'] as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->slug }}</td>
                        <td>
                            <span class="badge bg-{{ $category->is_active ? 'success' : 'secondary' }}">
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>{{ $category->created_at->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No categories found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
