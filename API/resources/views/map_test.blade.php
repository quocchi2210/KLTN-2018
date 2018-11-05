<!doctype html>
<html>
<meta name="csrf-token" content="{{ csrf_token() }}">
    <head>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script src="{{ asset('js/app.js') }}"></script>

        <style type="text/css">
            #map{
                height: 500px;
                width: 600px;
                margin: 0 auto;
            }
        </style>
    </head>
    <body>
    <h1>TEST MAP</h1>
    @yield('content') 

    <div class="container">
        <div id="map">
            
        </div>
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDZg4UjrDXfteRf8s6NErw0BKVfDSledVE"
    async defer></script>
    <button id="test">abc</button>
    </body>

    <script type="text/javascript">
    $(document).click(function (){
        $('#test').click(function (){
            alert('123');
        });

        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -34.397, lng: 150.644},
          zoom: 8
        });
    });
    </script>

</html>
