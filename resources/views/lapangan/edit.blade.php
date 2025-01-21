<x-layout>
    <x-slot name="title">
        BallGrouns | Edit Lapangan Bola
    </x-slot>

    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />
    @endpush

    <section class="content-header">
        <div class="container-fluid">
            <div class="mb-2 row">
                <div class="col-sm-6">
                    <h1>Edit Lapangan Bola</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('lapangan.index') }}">Data Lapangan Bola</a></li>
                        <li class="breadcrumb-item active">Edit Lapangan</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Form Input -->
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Form Edit Lapangan</h3>
                        </div>
                        <form action="{{ route('lapangan.update', $lapangan) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nama_lapangan">Nama Lapangan</label>
                                    <input type="text" class="form-control" id="nama_lapangan" name="nama_lapangan"
                                        value="{{ $lapangan->nama_lapangan }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required>{{ $lapangan->alamat }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Koordinat Tengah Lapangan</label>
                                    <div class="mb-3 input-group">
                                        <input type="text" class="form-control" id="latitude" name="latitude"
                                            placeholder="Latitude" value="{{ $lapangan->latitude }}" readonly>
                                        <input type="text" class="form-control" id="longitude" name="longitude"
                                            placeholder="Longitude" value="{{ $lapangan->longitude }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Area Lapangan</label>
                                    <input type="hidden" id="area_coordinates" name="area_coordinates"
                                        value="{{ json_encode($lapangan->area_coordinates) }}" required>
                                    <div id="area_info" class="mt-2">
                                        <small class="text-muted">Gunakan tools di map untuk menggambar area
                                            lapangan</small>
                                        <div id="area_size" class="mt-1">
                                            Luas area:
                                            {{ $lapangan->area_size < 10000 ? number_format($lapangan->area_size, 0) . ' m²' : number_format($lapangan->area_size / 10000, 2) . ' hektar' }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="aktif" {{ $lapangan->status === 'aktif' ? 'selected' : '' }}>
                                            Aktif</option>
                                        <option value="nonaktif"
                                            {{ $lapangan->status === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="foto">Foto Lapangan</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file"
                                                class="custom-file-input @error('foto') is-invalid @enderror"
                                                id="foto" name="foto" accept="image/*">
                                            <label class="custom-file-label" for="foto">
                                                {{ $lapangan->foto ? basename($lapangan->foto) : 'Pilih file' }}
                                            </label>
                                        </div>
                                    </div>
                                    <small class="text-muted">Format: JPEG, PNG, JPG (Max. 2MB)</small>
                                    @error('foto')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <!-- Current Image Preview -->
                                    <div class="mt-3" id="currentImage">
                                        @if ($lapangan->foto)
                                            <div class="mb-2">Foto Saat Ini:</div>
                                            <div class="position-relative">
                                                <img src="{{ asset($lapangan->foto) }}"
                                                    alt="Foto {{ $lapangan->nama_lapangan }}"
                                                    class="rounded shadow-sm img-fluid"
                                                    style="max-width: 100%; height: auto;">
                                            </div>
                                        @endif
                                    </div>

                                    <!-- New Image Preview -->
                                    <div class="mt-3" id="imagePreview" style="display: none;"></div>
                                </div>

                                <div class="form-group">
                                    <label for="area_color">Warna Area Lapangan</label>
                                    <input type="color" class="form-control @error('area_color') is-invalid @enderror"
                                        id="area_color" name="area_color"
                                        value="{{ old('area_color', $lapangan->area_color) }}" style="height: 40px;">
                                    @error('area_color')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                <a href="{{ route('lapangan.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                            <input type="hidden" id="area_size_input" name="area_size"
                                value="{{ $lapangan->area_size }}">
                        </form>
                    </div>
                </div>
                <!-- Map -->
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Pilih Lokasi & Gambar Area Lapangan</h3>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var centerMarker;
                var drawnItems = new L.FeatureGroup();

                var map = L.map('map', {
                    center: [{{ $lapangan->latitude }}, {{ $lapangan->longitude }}],
                    zoom: 15
                });

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                map.addLayer(drawnItems);

                // Initialize center marker
                centerMarker = L.marker([{{ $lapangan->latitude }}, {{ $lapangan->longitude }}]).addTo(map);

                // Initialize existing polygon
                var existingCoordinates = {!! json_encode($lapangan->area_coordinates) !!};
                if (existingCoordinates && existingCoordinates.length > 0) {
                    var polygon = L.polygon(existingCoordinates, {
                        color: '{{ $lapangan->area_color }}'
                    });
                    drawnItems.addLayer(polygon);
                }

                var drawControl = new L.Control.Draw({
                    draw: {
                        marker: false,
                        circle: false,
                        circlemarker: false,
                        rectangle: false,
                        polyline: false,
                        polygon: {
                            allowIntersection: false,
                            drawError: {
                                color: '#e1e100',
                                message: '<strong>Area lapangan tidak boleh berpotongan!</strong>'
                            },
                            shapeOptions: {
                                color: '#3388ff'
                            }
                        }
                    },
                    edit: {
                        featureGroup: drawnItems,
                        remove: true
                    }
                });
                map.addControl(drawControl);

                // Handle center marker creation
                map.on('click', function(e) {
                    var lat = e.latlng.lat;
                    var lng = e.latlng.lng;

                    document.getElementById('latitude').value = lat.toFixed(6);
                    document.getElementById('longitude').value = lng.toFixed(6);

                    if (centerMarker) {
                        centerMarker.setLatLng(e.latlng);
                    } else {
                        centerMarker = L.marker(e.latlng).addTo(map);
                    }
                });

                // Handle polygon creation
                map.on('draw:created', function(e) {
                    drawnItems.clearLayers();
                    var layer = e.layer;
                    drawnItems.addLayer(layer);

                    // Save coordinates
                    var coordinates = layer.getLatLngs()[0].map(function(latLng) {
                        return [latLng.lat, latLng.lng];
                    });
                    document.getElementById('area_coordinates').value = JSON.stringify(coordinates);

                    // Calculate and display area
                    var area = L.GeometryUtil.geodesicArea(layer.getLatLngs()[0]);
                    var areaText = area < 10000 ?
                        Math.round(area) + ' m²' :
                        Math.round(area / 10000 * 100) / 100 + ' hektar';
                    document.getElementById('area_size').innerHTML = 'Luas area: ' + areaText;
                    document.getElementById('area_size_input').value = area;
                });

                // Handle polygon editing
                map.on('draw:edited', function(e) {
                    var layers = e.layers;
                    layers.eachLayer(function(layer) {
                        var coordinates = layer.getLatLngs()[0].map(function(latLng) {
                            return [latLng.lat, latLng.lng];
                        });
                        document.getElementById('area_coordinates').value = JSON.stringify(coordinates);

                        // Update area calculation
                        var area = L.GeometryUtil.geodesicArea(layer.getLatLngs()[0]);
                        var areaText = area < 10000 ?
                            Math.round(area) + ' m²' :
                            Math.round(area / 10000 * 100) / 100 + ' hektar';
                        document.getElementById('area_size').innerHTML = 'Luas area: ' + areaText;
                        document.getElementById('area_size_input').value = area;
                    });
                });

                // Handle polygon deletion
                map.on('draw:deleted', function(e) {
                    document.getElementById('area_coordinates').value = '';
                    document.getElementById('area_size').innerHTML = '';
                    document.getElementById('area_size_input').value = '';
                });
            });
            document.getElementById('foto').addEventListener('change', function(e) {
                const file = e.target.files[0];
                const preview = document.getElementById('imagePreview');
                const label = document.querySelector('.custom-file-label');

                if (file) {
                    label.textContent = file.name;
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.style.display = 'block';
                        preview.querySelector('img').src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                } else {
                    preview.style.display = 'none';
                    label.textContent = 'Pilih file';
                }
            });
            document.getElementById('area_color').addEventListener('change', function(e) {
                if (drawnItems) {
                    drawnItems.eachLayer(function(layer) {
                        layer.setStyle({
                            color: e.target.value
                        });
                    });
                }

                drawControl.setDrawingOptions({
                    polygon: {
                        shapeOptions: {
                            color: e.target.value
                        }
                    }
                });
            });
            document.getElementById('foto').addEventListener('change', function(e) {
                const file = e.target.files[0];
                const preview = document.getElementById('imagePreview');
                const currentImage = document.getElementById('currentImage');
                const label = document.querySelector('.custom-file-label');

                if (file) {
                    // Update file input label
                    label.textContent = file.name;

                    // Create preview for new image
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Show new image preview container
                        preview.style.display = 'block';

                        // Create preview container with modern styling
                        preview.innerHTML = `
                <div class="mb-2">Foto Baru:</div>
                <div class="position-relative">
                    <img src="${e.target.result}"
                         class="rounded shadow-sm img-fluid"
                         style="max-width: 100%; height: auto;">
                    <div class="top-0 m-2 position-absolute end-0">
                        <button type="button" class="btn btn-sm btn-danger" id="removeNewImage">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>`;

                        // Hide current image when showing new preview
                        if (currentImage) {
                            currentImage.style.display = 'none';
                        }

                        // Add remove button functionality
                        document.getElementById('removeNewImage').addEventListener('click', function() {
                            preview.style.display = 'none';
                            if (currentImage) {
                                currentImage.style.display = 'block';
                            }
                            document.getElementById('foto').value = '';
                            label.textContent = 'Pilih file';
                        });
                    }
                    reader.readAsDataURL(file);
                } else {
                    // Reset everything if no file is selected
                    preview.style.display = 'none';
                    if (currentImage) {
                        currentImage.style.display = 'block';
                    }
                    label.textContent = 'Pilih file';
                }
            });
        </script>
    @endpush
</x-layout>
