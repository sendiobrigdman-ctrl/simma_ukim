@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-semibold mb-6">Mitra Dashboard</h1>

    <div class="grid grid-cols-3 gap-4">
        <div class="bg-white p-4 shadow rounded">
            <div class="text-sm text-gray-500">Active Jobs</div>
            <div class="text-2xl font-bold">{{ $activeJobs }}</div>
        </div>

        <div class="bg-white p-4 shadow rounded">
            <div class="text-sm text-gray-500">New Applicants (Pending)</div>
            <div class="text-2xl font-bold">{{ $newApplicants }}</div>
        </div>

        <div class="bg-white p-4 shadow rounded">
            <div class="text-sm text-gray-500">Unverified Logbooks (Pending)</div>
            <div class="text-2xl font-bold">{{ $unverifiedLogbooks }}</div>
        </div>
    </div>
</div>
@endsection
