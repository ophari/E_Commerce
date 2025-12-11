@extends('user.layout.app')

@section('title', 'Edit Profil | Watch Store')

@section('content')
<div class="container mt-5" style="max-width: 850px;">

    {{-- ILUSTRASI HEADER --}}
    <div class="text-center mb-4">
        <img src="https://cdn-icons-png.flaticon.com/512/9131/9131529.png"
             alt="profile icon"
             style="width: 120px; opacity: 0.9;">
        <h3 class="fw-bold mt-3">Pengaturan Profil</h3>
        <p class="text-muted">Perbarui informasi akun Anda dengan mudah</p>
    </div>

    {{-- CARD FORM --}}
    <div class="card shadow-sm border-0 rounded-4">

        {{-- ALERT SUCCESS --}}
        @if(session('success'))
            <div class="alert alert-success m-3 rounded-3">
                {{ session('success') }}
            </div>
        @endif

        {{-- ALERT ERROR --}}
        @if($errors->any())
            <div class="alert alert-danger m-3 rounded-3">
                <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card-body px-4 pb-4">

            <form action="{{ route('user.profile.update') }}" method="POST">
                @csrf

                <div class="row g-4">

                    {{-- Nama --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" name="name"
                            value="{{ old('name', $user->name) }}"
                            class="form-control form-control-lg rounded-3 @error('name') is-invalid @enderror">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email"
                            value="{{ $user->email }}"
                            class="form-control form-control-lg rounded-3" readonly>
                        <small class="text-muted">Email tidak dapat diubah.</small>
                    </div>

                    {{-- Nomor Telepon --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nomor Telepon</label>
                        <input type="text" name="phone"
                            value="{{ old('phone', $user->phone) }}"
                            class="form-control form-control-lg rounded-3 @error('phone') is-invalid @enderror"
                            placeholder="Contoh: 081234567890">
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Alamat --}}
                    <div class="col-12">
                        <label class="form-label fw-semibold">Alamat Lengkap</label>
                        <textarea name="address" rows="3"
                            class="form-control form-control-lg rounded-3 @error('address') is-invalid @enderror"
                            placeholder="Masukkan alamat lengkap Anda...">{{ old('address', $user->address) }}</textarea>
                        @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                </div>

                {{-- Tombol --}}
                <div class="d-flex justify-content-between mt-4 gap-2">

                    <button type="button"
                        class="btn btn-outline-danger flex-grow-1 rounded-pill fw-bold py-2"
                        data-bs-toggle="modal"
                        data-bs-target="#confirmDeleteModal">
                        Hapus Akun
                    </button>

                    {{-- Tombol Simpan --}}
                    <button type="submit"
                        class="btn btn-primary flex-grow-1 rounded-pill fw-bold py-2">
                        Simpan Perubahan
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>


{{-- =============================== --}}
{{-- MODAL KONFIRMASI HAPUS AKUN --}}
{{-- =============================== --}}
<div class="modal fade" id="confirmDeleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">

            <div class="modal-header">
                <h5 class="modal-title fw-bold">Konfirmasi Penghapusan Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p class="mb-2">Anda yakin ingin menghapus akun?</p>
                <p class="text-danger fw-semibold">Tindakan ini tidak dapat dibatalkan.</p>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>

                <form action="{{ route('user.profile.delete') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">Hapus Akun</button>
                </form>
            </div>

        </div>
    </div>
</div>

@endsection
