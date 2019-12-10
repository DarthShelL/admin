<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>DS Admin Panel</title>

    <!-- Fonts -->
{{--    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">--}}
{{--    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">--}}
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap&subset=cyrillic" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ URL::asset('css/admin/style.css') }}">
    @yield('styles')

    <!-- Scripts -->
    <script src="/js/admin/main.js"></script>
    @yield('scripts')
</head>
<body>
<div class="admin-panel">
    {!! DarthShelL\Admin\Helper::getMenu()->render() !!}
</div>
<div class="admin-content">
    <pre>{{ print_r(DarthShelL\Admin\Helper::getControllers()) }}</pre>
    @yield('content')
</div>
</body>
</html>

