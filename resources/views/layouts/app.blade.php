<!DOCTYPE HTML>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>{{ $settings['title'] }}</title>

    {{-- Basic meta --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="x-dns-prefetch-control" content="off">

    {{-- General --}}
    <meta name="description" content="{{ $settings['description'] }}">
    <meta name="keywords" content="{{ $settings['keywords'] }}">

    {{-- Open graph --}}
    <meta property="og:url" content="{!! url()->current() !!}">
    <meta property="og:locale" content="{{ app()->getLocale() }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $settings['title'] }}">
    <meta property="og:description" content="{{ $settings['description'] }}">
    <meta property="og:image" content="">

    {{-- Facebook --}}
    <meta property="fb:app_id" content="">
    <meta property="fb:admins" content="">

    {{-- Twitter --}}
    <meta name="twitter:image:alt" content="">
    <meta name="twitter:title" content="{{ $settings['title'] }}">
    <meta name="twitter:description" content="{{ $settings['description'] }}">
    <meta name="twitter:image" content="">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@">
    <meta name="twitter:creator" content="@">
    <meta name="twitter:url" content="{!! url()->current() !!}">

    @stack('css')
</head>
<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            @yield('header')
            @yield('nav')
            <main role="main">
                <div class="right_col" role="main">
                    @yield('content')
                </div>
            </main>
            @yield('footer')
        </div>
    </div>
    <script>
        var please_wait = "@lang('messages.info.please-wait')";
        var success_title = "@lang('content.titles.success')";
        var danger_title = "@lang('content.titles.danger')";
        var warning_title = "@lang('content.titles.warning')";
        var info_title = "@lang('content.titles.info')";
        var confirm_title = "@lang('content.buttons.confirm-delete')";
        var yes = "@lang('content.buttons.yes')";
        var no = "@lang('content.buttons.no')";
    </script>
    @stack('js')
</body>
</html>
