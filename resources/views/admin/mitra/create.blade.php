@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Mitra</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.mitra.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama Perusahaan</label>
            <input type="text" name="nama_perusahaan" value="{{ old('nama_perusahaan') }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" required>{{ old('alamat') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Email Kontak</label>
            <input type="email" name="email_kontak" value="{{ old('email_kontak') }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Telepon Kontak</label>
            <input type="text" name="telepon_kontak" value="{{ old('telepon_kontak') }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-control" required>
                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="non-aktif" {{ old('status') == 'non-aktif' ? 'selected' : '' }}>Non-aktif</option>
            </select>
        </div>
        <button class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
