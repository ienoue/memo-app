<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @yield('javascript')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/css/memo.css">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                                                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4 container">
            <div class="row">
                <div class="col-md-3">
                    <div class="card disp-height">
                        <div class="card-header">
                            タグ一覧
                        </div>
                        <div class="card-body overflow-auto">
                            <ul class="list-group mb-4">
                                <a href="{{ route('home') }}"
                                    class="list-group-item list-group-item-action {{ !isset($tagID) ? 'active' : '' }}">
                                    全て表示
                                </a>
                                @foreach ($tagsPaginate as $tag)
                                    <a href="{{ route('home', ['tagID' => $tag->id]) }}"
                                        class="list-group-item list-group-item-action text-truncate {{ isset($tagID) && $tag->id == $tagID ? 'active' : '' }}">
                                        {{ $tag->name }}
                                    </a>
                                @endforeach
                            </ul>
                            {{ $tagsPaginate->links() }}
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card disp-height">
                        <div class="card-header d-flex justify-content-between">
                            メモ一覧
                            <a href="{{ route('home') }}"><i class="fa-solid fa-circle-plus"></i></i></a>
                        </div>
                        <div class="card-body overflow-auto">
                            <div class="mb-4">
                                <ul class="list-group">
                                    @foreach ($memosPaginate as $memo)
                                        <a href="{{ route('edit', ['id' => $memo->id, 'tagID' => $tagID]) }}"
                                            class="list-group-item list-group-item-action text-truncate {{ isset($id) && $memo->id == $id ? 'active' : '' }}">
                                            {{ $memo->content }}
                                        </a>
                                    @endforeach
                                </ul>
                            </div>
                            {{ $memosPaginate->links() }}
                        </div>
                    </div>
                </div>
                <div class="col-md-5">@yield('content')</div>
            </div>
        </main>
    </div>
</body>

</html>
