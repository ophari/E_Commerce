@extends('user.layout.app')

@section('title', 'Edit Profil | Watch Store')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Edit Profil</h2>

    <form action="{{ route('user.profile.update') }}" method="POST">
        @csrf

        <div class="row g-3">
            {{-- Nama --}}
            <div class="col-md-6">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" name="name" id="name"
                       value="{{ old('name', $user->name) }}"
                       class="form-control @error('name') is-invalid @enderror">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Email --}}
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email"
                       value="{{ $user->email }}"
                       class="form-control" readonly>
                <small class="text-muted">Email tidak dapat diubah di sini.</small>
            </div>

            {{-- Nomor Telepon --}}
            <div class="col-md-6">
                <label for="phone" class="form-label">Nomor Telepon</label>
                <input type="text" name="phone" id="phone"
                       value="{{ old('phone', $user->phone) }}"
                       class="form-control @error('phone') is-invalid @enderror"
                       placeholder="Contoh: 081234567890">
                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Alamat --}}
            <div class="col-12">
                <label for="address" class="form-label">Alamat Lengkap</label>
                <textarea name="address" id="address" rows="3"
                          class="form-control @error('address') is-invalid @enderror"
                          placeholder="Jalan, nomor rumah, kelurahan, kecamatan">{{ old('address', $user->address) }}</textarea>
                @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Tombol Simpan --}}
            <div class="col-12 mt-3">
                <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
            </div>
        </div>
    </form>
</div>
@endsection
