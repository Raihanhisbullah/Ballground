<x-layout>
    <x-slot name="title">
        BallGrounds | Detail Pengguna
    </x-slot>

    <section class="content-header">
        <div class="container-fluid">
            <div class="mb-2 row">
                <div class="col-sm-6">
                    <h1>Detail Pengguna</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Data Pengguna</a></li>
                        <li class="breadcrumb-item active">Detail Pengguna</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                    src="{{ asset($user->profile_photo_path) }}" alt="Profile picture">
                            </div>

                            <h3 class="text-center profile-username">{{ $user->name }}</h3>
                            <p class="text-center text-muted">{{ $user->role_label }}</p>

                            <ul class="mb-3 list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <b>Status</b>
                                    <span class="float-right">
                                        <span
                                            class="badge badge-{{ $user->status === 'active' ? 'success' : 'danger' }} badge-pill">
                                            {{ ucfirst($user->status) }}
                                        </span>
                                    </span>
                                </li>
                                <li class="list-group-item">
                                    <b>Bergabung Sejak</b>
                                    <span class="float-right">{{ $user->created_at->format('d M Y') }}</span>
                                </li>
                            </ul>

                            <a href="{{ route('user.edit', $user) }}" class="btn btn-warning btn-block">
                                <i class="mr-1 fas fa-edit"></i> Edit Pengguna
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Informasi Detail</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="200">Nama Lengkap</th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th>Role</th>
                                    <td>{{ $user->role_label }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{ ucfirst($user->status) }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Registrasi</th>
                                    <td>{{ $user->created_at->format('d M Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Terakhir Diupdate</th>
                                    <td>{{ $user->updated_at->format('d M Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
