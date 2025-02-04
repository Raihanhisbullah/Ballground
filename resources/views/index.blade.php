<x-layout>
    <x-slot name="title">
        BallGrounds | Welcome
    </x-slot>

    <section class="py-5 text-white hero bg-primary">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="display-4">Welcome to BallGrounds</h1>
                    <p class="lead">Find and book the best football fields in your area</p>
                    @guest
                        <div class="mt-4">
                            <a href="{{ route('login') }}" class="btn btn-light btn-lg me-3">Login</a>
                            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">Register</a>
                        </div>
                    @endguest
                </div>
                <div class="col-md-6">
                    <img src="{{ asset('img/logo.png') }}" alt="Football field" class="rounded shadow img-fluid">
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <h2 class="mb-4 text-center">Featured Fields</h2>
            <div class="row">
                @foreach ($fields as $field)
                    <div class="mb-4 col-md-4">
                        <div class="card h-100">
                            @if ($field->foto)
                                <img src="{{ $field->foto }}" class="card-img-top" alt="{{ $field->nama_lapangan }}">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $field->nama_lapangan }}</h5>
                                <p class="card-text">{{ Str::limit($field->alamat, 100) }}</p>
                            </div>
                            <div class="bg-white card-footer">
                                <a href="{{ route('lapangan.show', $field->id) }}" class="btn btn-primary">View
                                    Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layout>
