<x-layout>
    <x-slot name="title">
        BallGrounds | Dashboard
    </x-slot>

    <section class="content-header">
        <div class="container-fluid">
            <div class="mb-4 row">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard Overview</h1>
                    <p class="text-muted">Welcome to BallGrounds Management System</p>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-gradient-info">
                        <div class="inner">
                            <h3>{{ $totalFields }}</h3>
                            <p>Total Football Fields</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-futbol"></i>
                        </div>
                        <a href="{{ route('lapangan.index') }}" class="small-box-footer">View Details <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-gradient-success">
                        <div class="inner">
                            <h3>{{ $fieldPercentage }}<sup style="font-size: 20px">%</sup></h3>
                            <p>Active Fields Rate</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <a href="{{ route('lapangan.index') }}" class="small-box-footer">View Details <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-gradient-warning">
                        <div class="inner">
                            <h3>{{ $activeUsers }}</h3>
                            <p>Active Users</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="{{ route('user.index') }}" class="small-box-footer">View Details <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="mr-2 fas fa-map-marked-alt"></i>
                                Football Fields Map Overview
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="p-0 card-body">
                            <div id="map" style="height: 600px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            var map;
            var markers = [];

            document.addEventListener('DOMContentLoaded', function() {
                // Initialize map
                map = L.map('map').setView([-0.2245441504724768, 100.6319326148181], 15);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                // Add custom control
                var customControl = L.control({
                    position: 'topright'
                });

                customControl.onAdd = function(map) {
                    var div = L.DomUtil.create('div', 'leaflet-bar leaflet-control');
                    div.innerHTML = `
                <div style="background: white; padding: 10px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                    <button class="btn btn-sm btn-info" onclick="centerMap()">
                        <i class="fas fa-crosshairs"></i> Center Map
                    </button>
                </div>
            `;
                    return div;
                };
                customControl.addTo(map);

                // Load football field data
                loadFieldMarkers();
            });

            function loadFieldMarkers() {
                fetch('{{ route('lapangan.map-data') }}')
                    .then(response => response.json())
                    .then(data => {
                        // Clear existing markers
                        markers.forEach(marker => marker.remove());
                        markers = [];

                        // Add new markers
                        data.forEach(field => {
                            const marker = L.marker([field.latitude, field.longitude])
                                .addTo(map);

                            // Create popup content
                            const popupContent = `
                        <div class="text-center">
                            <h6 class="mb-2">${field.nama_lapangan}</h6>
                            ${field.foto ?
                                `<img src="${field.foto}" alt="${field.nama_lapangan}"
                                                    class="mb-2 img-thumbnail" style="max-width: 150px;">`
                                : ''
                            }
                            <p class="mb-1"><small>${field.alamat}</small></p>
                            <a href="/lapangan/${field.id}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </div>
                    `;

                            marker.bindPopup(popupContent);
                            markers.push(marker);
                        });

                        // Adjust map bounds to show all markers
                        if (markers.length > 0) {
                            const group = new L.featureGroup(markers);
                            map.fitBounds(group.getBounds().pad(0.1));
                        }
                    })
                    .catch(error => {
                        console.error('Error loading field data:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to load football field data'
                        });
                    });
            }

            function centerMap() {
                if (markers.length > 0) {
                    const group = new L.featureGroup(markers);
                    map.fitBounds(group.getBounds().pad(0.1));
                } else {
                    map.setView([-0.2245441504724768, 100.6319326148181], 15);
                }
            }
        </script>
    @endpush
</x-layout>
