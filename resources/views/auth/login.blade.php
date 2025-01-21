<x-layout>
    <x-slot name="title">
        BallGrounds | Login
    </x-slot>

    <div class="login-box">
        <div class="login-logo">
            <a href="{{ url('/') }}"><b>Ball</b>Grounds</a>
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form action="{{ route('login.process') }}" method="POST"> <!-- Changed this line -->
                    @csrf
                    <div class="mb-3">
                        <div class="input-group">
                            <input type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror" placeholder="Email"
                                value="{{ old('email') }}" required autofocus>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        @error('email')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="input-group">
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                                required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        @error('password')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember" name="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .login-box {
                width: 400px;
                margin: 7% auto;
            }

            @media (max-width: 576px) {
                .login-box {
                    width: 90%;
                    margin-top: 20px;
                }
            }
        </style>
    @endpush
</x-layout>
