@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Admin Dashboard</h1>
    <div class="row mt-4">
        <div class="col-md-3 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Pengguna</h5>
                    <p class="display-4">{{ $totalUsers ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Lowongan</h5>
                    <p class="display-4">{{ $totalLowongan ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Aplikasi</h5>
                    <p class="display-4">{{ $totalAplikasi ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Mitra</h5>
                    <p class="display-4">{{ $totalMitra ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
