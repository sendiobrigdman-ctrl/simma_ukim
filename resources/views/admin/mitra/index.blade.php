@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Data Mitra</h1>
    <a href="{{ route('admin.mitra.create') }}" class="btn btn-primary mb-3">Tambah Mitra</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Perusahaan</th>
                <th>Alamat</th>
                <th>Email Kontak</th>
                <th>Telepon Kontak</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mitras as $mitra)
            <tr>
                <td>{{ $mitra->id }}</td>
                <td>{{ $mitra->nama_perusahaan }}</td>
                <td>{{ $mitra->alamat }}</td>
                <td>{{ $mitra->email_kontak }}</td>
                <td>{{ $mitra->telepon_kontak }}</td>
                <td>{{ ucfirst($mitra->status) }}</td>
                <td>
                    <a href="{{ route('admin.mitra.edit', $mitra) }}" class="btn btn-sm btn-secondary">Edit</a>
                    <form action="{{ route('admin.mitra.destroy', $mitra) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus data mitra?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $mitras->links() }}
</div>
@endsection
