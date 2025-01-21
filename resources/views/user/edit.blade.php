<x-layout>
    <x-slot name="title">
        BallGrounds | Edit Pengguna
    </x-slot>

    <section class="content-header">
        <div class="container-fluid">
            <div class="mb-2 row">
                <div class="col-sm-6">
                    <h1>Edit Pengguna</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Data Pengguna</a></li>
                        <li class="breadcrumb-item active">Edit Pengguna</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Pengguna</h3>
                </div>
                <form action="{{ route('user.update', $user) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password">Password Baru</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password">
                                    <small class="form-text text-muted">
                                        Kosongkan jika tidak ingin mengubah password
                                    </small>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="role">Role <span class="text-danger">*</span></label>
                                    <select class="form-control @error('role') is-invalid @enderror" id="role"
                                        name="role" required>
                                        <option value="">Pilih Role</option>
                                        <option value="admin"
                                            {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="user"
                                            {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-control @error('status') is-invalid @enderror" id="status"
                                        name="status" required>
                                        <option value="">Pilih Status</option>
                                        <option value="active"
                                            {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="inactive"
                                            {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Nonaktif
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Foto Profil</label>
                                    <div class="mb-3 text-center">
                                        <img id="preview"
                                            src="{{ $user->profile_photo_path ? Storage::url($user->profile_photo_path) : asset('img/default-user.png') }}"
                                            alt="Preview" class="img-circle" style="width: 100px; height: 100px;">
                                    </div>
                                    <div class="custom-file">
                                        <input type="file"
                                            class="custom-file-input @error('profile_photo') is-invalid @enderror"
                                            id="profile_photo" name="profile_photo" accept="image/*">
                                        <label class="custom-file-label" for="profile_photo">Pilih file baru</label>
                                        @error('profile_photo')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <small class="form-text text-muted">
                                        Format: JPG, PNG. Maksimal 2MB.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="mr-1 fas fa-save"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('user.show', $user) }}" class="btn btn-secondary">
                            <i class="mr-1 fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const input = document.querySelector('.custom-file-input');
                const preview = document.getElementById('preview');

                input.addEventListener('change', function(e) {
                    // Update label file
                    const fileName = e.target.files[0].name;
                    const nextSibling = e.target.nextElementSibling;
                    nextSibling.innerText = fileName;

                    // Preview image
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();

                        reader.addEventListener('load', function() {
                            preview.src = this.result;
                        });

                        reader.readAsDataURL(file);
                    }
                });
            });
        </script>
    @endpush
</x-layout>
