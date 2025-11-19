@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $lowongan->title }}</h1>

        <p>{{ $lowongan->description }}</p>

        <form method="POST" action="{{ route('admin.lowongans.moderation.updateStatus', $lowongan) }}">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="{{ \App\Models\Lowongan::STATUS_APPROVED }}">Approved</option>
                    <option value="{{ \App\Models\Lowongan::STATUS_REJECTED }}">Rejected</option>
                    <option value="{{ \App\Models\Lowongan::STATUS_PENDING }}">Pending</option>
                </select>
            </div>

            <button class="btn btn-primary" type="submit">Update Status</button>
            <a href="{{ route('admin.lowongans.moderation.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
@endsection
