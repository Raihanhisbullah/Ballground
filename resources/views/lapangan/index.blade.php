<x-layout>
    <x-slot name="title">
        BallGrouns | Data Lapangan Bola
    </x-slot>

    <section class="content-header">
        <div class="container-fluid">
            <div class="mb-2 row">
                <div class="col-sm-6">
                    <h1>Data Lapangan Bola</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Data Lapangan Bola</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Lapangan Bola</h3>
                    <div class="card-tools">
                        <a href="{{ route('lapangan.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Lapangan
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
                        <table class="table table-striped table-hover" id="lapangan-table">
                            <thead class="thead-dark">
                                <tr class="text-center">
                                    <th width="5%">No</th>
                                    <th>Nama Lapangan</th>
                                    <th>Foto</th>
                                    <th>Alamat</th>
                                    <th>Koordinat</th>
                                    <th>Luas Area</th>
                                    <th>Status</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lapangan as $index => $field)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td><strong>{{ $field->nama_lapangan }}</strong></td>
                                        <td class="text-center">
                                            @if ($field->foto)
                                                <img src="{{ asset($field->foto) }}"
                                                    alt="Foto {{ $field->nama_lapangan }}" class="img-thumbnail"
                                                    style="max-height: 50px;">
                                            @else
                                                <span class="badge badge-secondary">Tidak ada foto</span>
                                            @endif
                                        </td>
                                        <td>{{ $field->alamat }}</td>
                                        <td class="text-center">
                                            <span class="badge badge-info">
                                                <i class="mr-1 fas fa-map-marker-alt"></i>
                                                {{ $field->latitude }}, {{ $field->longitude }}
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            @if ($field->area_size >= 10000)
                                                {{ number_format($field->area_size / 10000, 2) }} hektar
                                            @else
                                                {{ number_format($field->area_size, 0) }} m²
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge badge-{{ $field->status === 'aktif' ? 'success' : 'danger' }} badge-pill">
                                                <i
                                                    class="fas fa-{{ $field->status === 'aktif' ? 'check' : 'times' }} mr-1"></i>
                                                {{ ucfirst($field->status) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Aksi">
                                                <a href="{{ route('lapangan.show', $field) }}"
                                                    class="mx-1 btn btn-info btn-sm" data-toggle="tooltip"
                                                    title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('lapangan.edit', $field) }}"
                                                    class="mx-1 btn btn-warning btn-sm" data-toggle="tooltip"
                                                    title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('lapangan.destroy', $field) }}" method="POST"
                                                    class="mx-1 d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        class="mx-1 btn btn-danger btn-sm delete-lapangan"
                                                        data-lapangan-id="{{ $field->id }}"
                                                        data-lapangan-name="{{ $field->nama_lapangan }}"
                                                        data-toggle="tooltip" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="py-4 text-center">
                                            <i class="fas fa-inbox fa-3x text-muted"></i>
                                            <p class="mt-2 mb-0">Tidak ada data lapangan</p>
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
        <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
    @endpush

    @push('scripts')
        <!-- DataTables -->
        <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script>
            $('#lapangan-table').DataTable({
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
            document.querySelectorAll('.delete-lapangan').forEach(button => {
                button.addEventListener('click', function() {
                    const lapanganId = this.getAttribute('data-lapangan-id');
                    const lapanganName = this.getAttribute('data-lapangan-name');

                    Swal.fire({
                        title: 'Konfirmasi Penghapusan',
                        html: `
                                <div class="mb-4 text-center">
                                    <i class="fas fa-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                                </div>
                                <p>Apakah Anda yakin ingin menghapus lapangan:</p>
                                <p class="font-weight-bold">${lapanganName}</p>
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
                            // Create and submit form for delete request
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = `/lapangan/${lapanganId}`;
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
                            form.submit();
                        }
                    });
                });
            });
        </script>
    @endpush
</x-layout>
