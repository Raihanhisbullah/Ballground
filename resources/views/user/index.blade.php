<x-layout>
    <x-slot name="title">
        BallGrounds | Data Pengguna
    </x-slot>

    <section class="content-header">
        <div class="container-fluid">
            <div class="mb-2 row">
                <div class="col-sm-6">
                    <h1>Data Pengguna</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Data Pengguna</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Pengguna</h3>
                    <div class="card-tools">
                        <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-user-plus"></i> Tambah Pengguna
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="mr-2 fas fa-check-circle"></i>{{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="mr-2 fas fa-exclamation-circle"></i>{{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="users-table">
                            <thead class="thead-dark">
                                <tr class="text-center">
                                    <th width="5%">No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Tanggal Registrasi</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $index => $user)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $user->profile_photo_url }}" alt="Profile"
                                                    class="mr-2 img-circle" style="width: 32px; height: 32px;">
                                                <strong>{{ $user->name }}</strong>
                                            </div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td class="text-center">
                                            <span class="badge badge-info badge-pill">
                                                <i class="mr-1 fas fa-user-tag"></i>
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge badge-{{ $user->status === 'active' ? 'success' : 'danger' }} badge-pill">
                                                <i
                                                    class="fas fa-{{ $user->status === 'active' ? 'check' : 'times' }} mr-1"></i>
                                                {{ ucfirst($user->status) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            {{ $user->created_at->format('d M Y') }}
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Aksi">
                                                <a href="{{ route('user.show', $user) }}"
                                                    class="mx-1 btn btn-info btn-sm" data-toggle="tooltip"
                                                    title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('user.edit', $user) }}"
                                                    class="mx-1 btn btn-warning btn-sm" data-toggle="tooltip"
                                                    title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('user.destroy', $user) }}" method="POST"
                                                    class="mx-1 d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm delete-user"
                                                        data-user-id="{{ $user->id }}"
                                                        data-user-name="{{ $user->name }}" data-toggle="tooltip"
                                                        title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>

                                                    @push('scripts')
                                                        <script>
                                                            document.addEventListener('DOMContentLoaded', function() {
                                                                // Delegasi event untuk tombol delete
                                                                document.querySelectorAll('.delete-user').forEach(button => {
                                                                    button.addEventListener('click', function() {
                                                                        const userId = this.getAttribute('data-user-id');
                                                                        const userName = this.getAttribute('data-user-name');

                                                                        Swal.fire({
                                                                            title: 'Konfirmasi Penghapusan',
                                                                            html: `
                                                                                <div class="mb-4 text-center">
                                                                                    <i class="fas fa-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                                                                                </div>
                                                                                <p>Apakah Anda yakin ingin menghapus pengguna:</p>
                                                                                <p class="font-weight-bold">${userName}</p>
                                                                                <p class="mb-0 text-danger">Tindakan ini tidak dapat dibatalkan!</p>
                                                                            `,
                                                                            showCancelButton: true,
                                                                            confirmButtonColor: '#dc3545',
                                                                            cancelButtonColor: '#6c757d',
                                                                            confirmButtonText: 'Ya, Hapus!',
                                                                            cancelButtonText: 'Batal',
                                                                            reverseButtons: true,
                                                                            focusCancel: true
                                                                        }).then((result) => {
                                                                            if (result.isConfirmed) {
                                                                                // Buat form untuk delete request
                                                                                const form = document.createElement('form');
                                                                                form.method = 'POST';
                                                                                form.action = `/user/${userId}`;
                                                                                form.style.display = 'none';

                                                                                const csrfInput = document.createElement('input');
                                                                                csrfInput.type = 'hidden';
                                                                                csrfInput.name = '_token';
                                                                                csrfInput.value = '{{ csrf_token() }}';

                                                                                const methodInput = document.createElement('input');
                                                                                methodInput.type = 'hidden';
                                                                                methodInput.name = '_method';
                                                                                methodInput.value = 'DELETE';

                                                                                form.appendChild(csrfInput);
                                                                                form.appendChild(methodInput);
                                                                                document.body.appendChild(form);

                                                                                // Submit form
                                                                                form.submit();
                                                                            }
                                                                        });
                                                                    });
                                                                });
                                                            });
                                                        </script>
                                                    @endpush
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-4 text-center">
                                            <i class="fas fa-users fa-3x text-muted"></i>
                                            <p class="mt-2 mb-0">Tidak ada data pengguna</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('styles')
        <!-- DataTables -->
        <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    @endpush

    @push('scripts')
        <!-- DataTables -->
        <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script>
            $(function() {
                $('#users-table').DataTable({
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                    "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                        '<"row"<"col-sm-12"tr>>' +
                        '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                });
            });
        </script>
    @endpush
</x-layout>
