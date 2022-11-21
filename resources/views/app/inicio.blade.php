@extends('layouts.portal')

@section('title') Inicio - @endsection
@section('meta_description')  @endsection

@section('css')
    <style>
        #mapa {
            width: 100%;
            height: 95vh;
            background-color: #eff7ff;
            /*background-image: url(../assets/img/map-image.png);*/
            background-repeat: no-repeat;
            background-position: center;
        }
    </style>
@endsection

@section('menu')
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="#page-top"><img src="{{asset('assets/img/logo-white.png')}}" alt="..." /></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars ms-1"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                    <li class="nav-item"><a class="nav-link" href="#mapa">Mapa</a></li>
                    <li class="nav-item"><a class="nav-link" href="#historial">Historial</a></li>
                </ul>
            </div>
        </div>
    </nav>
@endsection

@section('banner')
    <header class="masthead">
        <div class="container">
            <div class="masthead-subheading">Conoce el clima de</div>
            <div class="masthead-heading text-uppercase">Miami, Orlando, Nueva York</div>
            <div class="masthead-subheading">o cualquier parte del mundo</div>
            <a class="btn btn-primary btn-xl text-uppercase" href="#mapa">Ver mapa</a>
        </div>
    </header>
@endsection

@section('mapa')
    <div id="mapa"></div>
@endsection

@section('historico')
    <section class="page-section bg-light" id="historial">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-heading text-uppercase">Clima en <span id="city">Bogotá</span></h2>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <h5 id="description" class="section-heading text-uppercase">Lluvia débil</h5>
                    <img id="icon" src="https://openweathermap.org/img/wn/10d@4x.png" width="100">
                </div>
                <div class="col-lg-4">
                    <h1 id="temp" class="section-heading text-uppercase">17°</h1>
                    <h5 id="feels_like" class="section-heading text-uppercase">Sensación de 17°</h5>
                </div>
                <div class="col-lg-4">
                    <h3 class="section-heading text-uppercase"><i class="fa-solid fa-umbrella"></i></h3>
                    <h5 id="humidity" class="section-heading text-uppercase">50%</h5>
                    <h5 class="section-heading text-uppercase">Humedad</h5>
                </div>

                <a class="btn btn-primary btn-xl text-uppercase" href="#mapa">Ver mapa</a>
            </div>


            <hr>
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="section-heading text-uppercase">Historial</h2>
                    <table class="w-100" id="historial_clima">
                        
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection



@section('js')
    <script>

        // Crear root
        var root = am5.Root.new("mapa"); 

        // Asigna temas
        root.setThemes([am5themes_Animated.new(root)]);

        // Crear gráfica
        var chart = root.container.children.push(am5map.MapChart.new(root, {
            panX: "rotateX",
            projection: am5map.geoMercator()
        }));

        // crear la serie de polígonos
        var polygonSeries = chart.series.push(am5map.MapPolygonSeries.new(root, {
            geoJSON: am5geodata_worldLow,
            exclude: ["AQ"]
        }));

        polygonSeries.data.setAll([{
            id: "US",
            polygonSettings: {
                fill: am5.color(0x677935)
            }
        }]);

        // Crear la serie de puntos
        var pointSeries = chart.series.push(am5map.MapPointSeries.new(root, {
            latitudeField: "lat",
            longitudeField: "long"
        }));

        pointSeries.bullets.push(function(){
            var circle = am5.Circle.new(root, {
                radius: 10,
                fill: am5.color(0x03cfb4),
                stroke: root.interfaceColors.get("background"),
                strokeWidth: 2,
                tooltipText: "{name}"
            });

            circle.events.on("click", function(ev){
                verifica_humedad(ev.target.dataItem.dataContext.name,ev.target.dataItem.dataContext.id);
            });

            return am5.Bullet.new(root, {
                sprite: circle
            });
        });

        pointSeries.data.setAll(
            [
            @foreach($cities as $city)
                {
                    id: {{$city->id}},
                    long: {{$city->long}},
                    lat: {{$city->lat}},
                    name: "{{$city->name}}"
                },
            @endforeach
            ]
        );

        var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const historial = document.getElementById("historial");
        const historial_clima = document.getElementById("historial_clima");

        const city = document.getElementById("city");
        const desc = document.getElementById("description");
        const icon = document.getElementById("icon");
        const temp = document.getElementById("temp");
        const feels_like = document.getElementById("feels_like");
        const humidity = document.getElementById("humidity");

        function verifica_humedad(ciudad,ciudad_id){
            var dataString = {q:ciudad, appid: 'c20782fd274a066c936dc142387cbe24'},humedad="";
            fetch('https://api.openweathermap.org/data/2.5/weather?q=' + dataString.q + '&appid=' + dataString.appid)
            .then(request => request.json()).then(data => {
                // Verificamos datos yguardamos en el historial

                city.innerHTML = data.name;
                desc.innerHTML = translate_temp(data.weather[0].description);
                icon.src = 'https://openweathermap.org/img/wn/' + data.weather[0].icon + '@4x.png';
                temp.innerHTML = Math.floor(data.main.temp - 273.15) + '°C';
                feels_like.innerHTML = 'Sensación de ' + Math.floor(data.main.feels_like - 273.15) + '°C';
                humidity.innerHTML = data.main.humidity + '%';

                guarda_historial(ciudad_id,data.main.humidity,translate_temp(data.weather[0].description),'https://openweathermap.org/img/wn/' + data.weather[0].icon + '@4x.png',
                Math.floor(data.main.temp - 273.15),Math.floor(data.main.feels_like - 273.15));

                scroll(historial);
                carga_historial(ciudad_id);
            });
        }

        function guarda_historial(ciudad,humedad,desc,icon,temp,feels_like){
            var dataString = {ciudad:ciudad,humedad:humedad,desc:desc,icon:icon,temp:temp,feels_like:feels_like}
            fetch("{{route('guarda_historial')}}", {
                method:'POST',mode:'cors',body:JSON.stringify(dataString),headers:{'X-CSRF-TOKEN':token,'Content-Type':'application/json'}
            }).then((response) => response.json()).then((data) => {
                if(data.valid){
                    //alert("Consulta ejecutada con éxito");
                }else{
                    alert("Error en BD");
                }
            }).catch((error) => { console.error('Error:', error); });
        }

        function carga_historial(ciudad_id){
            var dataString = {ciudad:ciudad_id}
            fetch("{{route('carga_historial')}}", {
                method:'POST',mode:'cors',body:JSON.stringify(dataString),headers:{'X-CSRF-TOKEN':token,'Content-Type':'application/json'}
            }).then((response) => response.json()).then((data) => {
                if(data.msg_type == "success"){
                    // Cargo la parcial en un div
                    historial_clima.innerHTML = data.html;
                }else{
                    alert("Error en BD");
                }
            }).catch((error) => { console.error('Error:', error); });
        }

        function translate_temp(temp){
            // alert(temp);
            switch(temp.toLowerCase()){
                case 'clear sky': trans_temp = 'Cielo despejado';break;
                case 'few clouds': trans_temp = 'Algo nublado';break;
                case 'overcast clouds': trans_temp = 'Parcialmente nublado';break;
                case 'scattered clouds': trans_temp = 'Nublado';break;
                case 'broken clouds': trans_temp = 'Nubes oscuras';break;
                case 'shower rain': trans_temp = 'Aguacero';break;
                case 'rain': trans_temp = 'Lluvia';break;
                case 'snow': trans_temp = 'Nieve';break;
                case 'mist': trans_temp = 'Neblina';break;
            }
            return trans_temp;
        }

        function scroll(element){
            window.scrollTo({ top: element.offsetTop, behavior: 'smooth'});
        }
    </script>
@endsection