@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Menu Items</h1>

    <a href="{{ route('menu-items.create') }}" class="btn btn-success mb-3">Add New Item</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($menuItems as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>${{ $item->price }}</td>
                <td>
                    <a href="{{ route('menu-items.edit', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    <form action="{{ route('menu-items.destroy', $item->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
