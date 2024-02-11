<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<!-- Mirrored from seantheme.com/hud/ by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 11 Feb 2024 17:30:42 GMT -->
<head>
    <meta charset="utf-8">
    <title>HUD | Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content>
    <meta name="author" content>

    <link href="assets/css/vendor.min.css" rel="stylesheet">
    <link href="assets/css/app.min.css" rel="stylesheet">


    <link href="assets/plugins/jvectormap-next/jquery-jvectormap.css" rel="stylesheet">
    @yield('css')

</head>
<body>

<div id="app" class="app">
    @includeIf('layouts.header')
    @includeIf('layouts.sidebar')
    @includeIf('layouts.theme-panel')
    <div id="content" class="app-content">
        @yield('content')
    </div>

    <a href="#" data-toggle="scroll-to-top" class="btn-scroll-top fade"><i class="fa fa-arrow-up"></i></a>

</div>

<script src="assets/js/app.min.js" type="32a03d53bc6b70e3ca252a8c-text/javascript"></script>


<script src="assets/plugins/jvectormap-next/jquery-jvectormap.min.js" type="32a03d53bc6b70e3ca252a8c-text/javascript"></script>
<script src="assets/plugins/jvectormap-content/world-mill.js" type="32a03d53bc6b70e3ca252a8c-text/javascript"></script>
<script src="assets/plugins/apexcharts/dist/apexcharts.min.js" type="32a03d53bc6b70e3ca252a8c-text/javascript"></script>
<script src="assets/js/demo/dashboard.demo.js" type="32a03d53bc6b70e3ca252a8c-text/javascript"></script>
@yield('js')
</body>

<!-- Mirrored from seantheme.com/hud/ by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 11 Feb 2024 17:31:07 GMT -->
</html>
