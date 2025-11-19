@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-semibold mb-6">Mahasiswa Dashboard</h1>

    <div class="grid grid-cols-2 gap-4">
        <div class="bg-white p-4 shadow rounded">
            <div class="text-sm text-gray-500">Active Applications</div>
            <div class="text-2xl font-bold">{{ $activeApplications }}</div>
        </div>

        <div class="bg-white p-4 shadow rounded">
            <div class="text-sm text-gray-500">Today's Logbook Entries</div>
            <div class="text-2xl font-bold">{{ $todaysLogbooks }}</div>
        </div>
    </div>
</div>
@endsection
