@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Add Menu Item</h1>

    <form action="{{ route('menu-items.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Item Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="number" step="0.01" name="price" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Add Item</button>
    </form>
</div>
@endsection
