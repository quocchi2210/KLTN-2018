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

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD2zRNFHjN-zWhVNQ5PV8xa3Plw_2b4uxw"
    async defer></script>
    <button id="test">abc</button>
    </body>

    <script type="text/javascript">
    var map;
    var myLatLng;
    $(document).click(function (){
        $('#test').click(function (){
            alert('123');
        });

        // map = new google.maps.Map(document.getElementById('map'), {
        //   center: {lat: -34.397, lng: 150.644},
        //   zoom: 8
        // });
        geoLocationInit();
    });


    function geoLocationInit() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(success, fail);
        } else {
            alert("Browser not supported");
        }
    }

    function success(position) {
        console.log(position);
        var latval = position.coords.latitude;
        var lngval = position.coords.longitude;
        myLatLng = new google.maps.LatLng(latval, lngval);
        createMap(myLatLng);
        // nearbySearch(myLatLng, "school");

    }

    function fail() {
        alert("it fails");
    }
    //Create Map
    function createMap(myLatLng) {
        map = new google.maps.Map(document.getElementById('map'), {
            center: myLatLng,
            zoom: 12
        });
        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map
        });
    }
    //Create marker
    function createMarker(latlng, icn, name) {
        var marker = new google.maps.Marker({
            position: latlng,
            map: map,
            icon: icn,
            title: name
        });
    }
   
    </script>

</html>
