<x-layout>
    <x-slot name="title">
        BallGrouns | Detail Lapangan Bola
    </x-slot>

    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    @endpush

    <section class="content-header">
        <div class="container-fluid">
            <div class="mb-2 row">
                <div class="col-sm-6">
                    <h1>Detail Lapangan Bola</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('lapangan.index') }}">Data Lapangan Bola</a></li>
                        <li class="breadcrumb-item active">Detail Lapangan</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Detail Information -->
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Informasi Lapangan</h3>
                            <div class="card-tools">
                                <a href="{{ route('lapangan.edit', $lapangan) }}" class="btn btn-warning btn-sm">
                                    <i class="mr-1 fas fa-edit"></i>Edit
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover">
                                <tr>
                                    <th width="35%">Nama Lapangan</th>
                                    <td><strong>{{ $lapangan->nama_lapangan }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Foto Lapangan</th>
                                    <td>
                                        @if ($lapangan->foto)
                                            <img src="{{ asset($lapangan->foto) }}"
                                                alt="Foto {{ $lapangan->nama_lapangan }}"
                                                class="img-fluid img-thumbnail" style="max-height: 200px;">
                                        @else
                                            <span class="badge badge-secondary">Tidak ada foto</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>{{ $lapangan->alamat }}</td>
                                </tr>
                                <tr>
                                    <th>Koordinat</th>
                                    <td>
                                        <span class="badge badge-info">
                                            <i class="mr-1 fas fa-map-marker-alt"></i>
                                            {{ $lapangan->latitude }}, {{ $lapangan->longitude }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Luas Area</th>
                                    <td>
                                        @if ($lapangan->area_size >= 10000)
                                            {{ number_format($lapangan->area_size / 10000, 2) }} hektar
                                        @else
                                            {{ number_format($lapangan->area_size, 0) }} m²
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span
                                            class="badge badge-{{ $lapangan->status === 'aktif' ? 'success' : 'danger' }} badge-pill">
                                            <i
                                                class="fas fa-{{ $lapangan->status === 'aktif' ? 'check' : 'times' }} mr-1"></i>
                                            {{ ucfirst($lapangan->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Dibuat Pada</th>
                                    <td>{{ $lapangan->created_at->format('d M Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Terakhir Diupdate</th>
                                    <td>{{ $lapangan->updated_at->format('d M Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('lapangan.index') }}" class="btn btn-secondary">
                                <i class="mr-1 fas fa-arrow-left"></i>Kembali
                            </a>
                            <form action="{{ route('lapangan.destroy', $lapangan) }}" method="POST"
                                class="float-right d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus lapangan ini?')">
                                    <i class="mr-1 fas fa-trash"></i>Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Map -->
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Lokasi & Area Lapangan</h3>
                        </div>
                        <div class="card-body">
                            <div id="map" style="height: 500px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize map
                var map = L.map('map', {
                    center: [{{ $lapangan->latitude }}, {{ $lapangan->longitude }}],
                    zoom: 16
                });

                // Add tile layer
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                // Add center marker
                var marker = L.marker([{{ $lapangan->latitude }}, {{ $lapangan->longitude }}])
                    .addTo(map)
                    .bindPopup("<strong>{{ $lapangan->nama_lapangan }}</strong><br>{{ $lapangan->alamat }}");

                // Add area polygon
                var coordinates = {!! json_encode($lapangan->area_coordinates) !!};
                var coordinates = {!! json_encode($lapangan->area_coordinates) !!};
                if (coordinates && coordinates.length > 0) {
                    var polygon = L.polygon(coordinates, {
                        color: '{{ $lapangan->area_color }}',
                        fillOpacity: 0.3
                    }).addTo(map);

                    // Fit bounds to show both marker and polygon
                    map.fitBounds(polygon.getBounds());
                }
            });
        </script>
    @endpush
</x-layout>
