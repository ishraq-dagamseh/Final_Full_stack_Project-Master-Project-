@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Edit Menu Item</h1>

    <form action="{{ route('menu-items.update', $menuItem->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Item Name</label>
            <input type="text" name="name" class="form-control" value="{{ $menuItem->name }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="number" step="0.01" name="price" class="form-control" value="{{ $menuItem->price }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Item</button>
    </form>
</div>
@endsection
