@extends('layouts.app')

@section('content')

    <main class="container">
        <div class="position-relative overflow-hidden p-3 text-center bg-light">
            <div class="mx-auto image-banner">
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
    </main>

    @include('layouts.footer')
@endsection
