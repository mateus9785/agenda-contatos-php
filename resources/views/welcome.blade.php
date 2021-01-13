<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('font-awesome/css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <title>Agenda de contatos</title>
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a href="/" class="navbar-brand d-flex align-items-center">
                <i class="fas fa-users p-2"></i>
                <strong class="p-2">Agenda de contatos</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/home') }}">Home</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Cadastrar</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <main class="container">
        <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
            <div class="p-lg-5 mx-auto my-5 image-banner">
                <div class="text-banner">
                    <h1 class="fw-normal">Organize seus contatos de forma rápida e fácil!</h1>
                    <p class="lead fw-normal">Tenha mais liberdade, rapidez e segurança para organizar seus contatos em
                        nossa plataforma</p>
                </div>
            </div>
            <div class="product-device shadow-sm d-none d-md-block"></div>
            <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
        </div>

        <div class="row row-cols-1 row-cols-md-3 mb-3 mt-5 text-center">
            <div class="col">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header">
                        <h4 class="my-0 fw-normal">Grátis</h4>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title">R$ 0,00 <small class="text-muted">/ mês</small></h1>
                        <ul class="list-unstyled mt-3 mb-4">
                            <li>20 contatos incluídos</li>
                            <li>5 grupos de contatos incluídos</li>
                            <li>Suporte por chat</li>
                        </ul>
                        <a href="{{ route('register') }}" class="w-100 btn btn-lg btn-outline-primary">Cadastre-se
                            gratuitamente</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header">
                        <h4 class="my-0 fw-normal">Pro</h4>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title">R$ 10,00 <small class="text-muted">/ mês</small></h1>
                        <ul class="list-unstyled mt-3 mb-4">
                            <li>50 contatos incluídos</li>
                            <li>20 grupos de contatos incluídos</li>
                            <li>Suporte por email e chat</li>
                        </ul>
                        <a href="{{ route('register') }}" class="w-100 btn btn-lg btn-primary">Cadastre-se</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header">
                        <h4 class="my-0 fw-normal">Enterprise</h4>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title">R$ 30,00 <small class="text-muted">/ mês</small></h1>
                        <ul class="list-unstyled mt-3 mb-4">
                            <li>Contatos e grupos de contatos ilimitados</li>
                            <li>Importação de contatos</li>
                            <li>Suporte por email, chat e telefone</li>
                        </ul>
                        <a href="{{ route('register') }}" class="w-100 btn btn-lg btn-primary">Cadastre-se</a>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footer')
    </main>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
