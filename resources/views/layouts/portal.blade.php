<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    
    <title>@yield('title','') {{setting('site.title')}}</title>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0, minimum-scale=1.0, shrink-to-fit=no">
    <!--<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />-->
    <meta name="description" content="@yield('meta_description',setting('site.description'))">
    <meta name="author" content="John Alexander Ramirez">

    <meta name="format-detection" content="telephone=yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    @yield('metas')

    <link rel='canonical' href='{{ url()->current() }}' />
    <link rel="alternate" hreflang="x-default" href="{{ url()->current() }}" />
    <meta name="theme-color" content="#000000">
    <meta name="msapplication-TileColor" content="#000000">
    <meta name="msapplication-TileImage" content="{{Voyager::image(setting('site.favicon'))}}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{Voyager::image(setting('site.favicon'))}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{Voyager::image(setting('site.favicon'))}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{Voyager::image(setting('site.favicon'))}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{Voyager::image(setting('site.favicon'))}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{Voyager::image(setting('site.favicon'))}}">
    <link rel="shortcut icon" type="image/png" href="{{Voyager::image(setting('site.favicon'))}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{Voyager::image(setting('site.favicon'))}}">

    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>

    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="{{asset('assets/css/styles.css')}}" type="text/css" media="all" />

    @yield('css')

</head>

<body id="page-top">

    @yield('menu')  
    @yield('banner')
    @yield('mapa')
    @yield('historico')

    <!-- Footer-->
    <footer class="footer py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 text-lg-start">Derechos reservados &copy; John Ramírez 2022</div>
                <div class="col-lg-4 my-3 my-lg-0">
                    <a class="btn btn-dark btn-social mx-2" href="https://twitter.com/microstruct" aria-label="Twitter" target="_blank"><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-dark btn-social mx-2" href="https://www.facebook.com/AlexRamTech" aria-label="Facebook" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-dark btn-social mx-2" href="https://www.linkedin.com/in/microstruct/" aria-label="LinkedIn" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a class="link-dark text-decoration-none me-3" href="#!">Política de privacidad</a>
                    <a class="link-dark text-decoration-none" href="#!">Términos de uso</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('assets/js/scripts.js')}}"></script>

    <script src="//cdn.amcharts.com/lib/5/index.js"></script>
    <script src="//cdn.amcharts.com/lib/5/map.js"></script>
    <script src="//cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
    <script src="//cdn.amcharts.com/lib/5/themes/Animated.js"></script>

    @yield('js')

</body>
</html>
