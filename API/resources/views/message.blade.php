<html>

<head>
    <title>Demo chat</title>

        <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>

    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=geometry&key=AIzaSyBVLZZFaDU6nn96cbs59PfMBNXu9ZNdxYE&callback=initMap"
    async defer"></script>

</head>
<body>

    <div>
     <!--    <form action="send-message" method="POST">
        {{csrf_field()}}
        Name: <input type="text" name="author">
        <br>
        <br>
        Content: <textarea name="content" rows="5" style="width:100%"></textarea>
        <button type="submit" name="send">Send</button>
        </form> -->
        <!-- <script src="{{asset('js/jquery.min.js')}}"></script> -->

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.1/socket.io.js"></script>

        <script>



        // var socket = io('https://35.237.188.74:6001');
        // socket.on('chat:message',function(data){
        //     console.log(data)
        //     $('body').append('<p>'+data+'</p>')
        //     // if($('#'+data.id).length == 0){
        //     //
        //     // }
        //     // else{
        //     //     console.log('Đã có tin nhắn')
        //     // }
        // })

        </script>
    </div>

    <div id="map"></div>

    <script>

      function initMap() {

var map;
var json = {
  "overview_polyline": {
    "points": "_hx`Am`cjSL@h@Zp@Ll@uA`A{B@?F@D@D?LJVV|@f@vIbEl@Xb@Zr@v@fCtEzExI|BfE`EtHnAbCj@vAnDvHh@jAZz@~AtDPLtCpG~AtD|AfDhCxF@HJV@Ll@jArAzCjBjEzB~E`BfE`A~Bx@xAdFfLFN@b@Ap@KbAwG~DoDxBwDfCaCzAr@fAb@x@DPB`@IpAUlA?r@iBIGD@J@F?DAHGAIA"
  }
};

function initialize() {
  var map = new google.maps.Map(
    document.getElementById("map"), {
      center: new google.maps.LatLng(10.7667964, 106.6519856),
      zoom: 18,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
  var polyline = new google.maps.Polyline({
    path: google.maps.geometry.encoding.decodePath(json.overview_polyline.points),
    map: map,
    strokeWeight: 8,
    strokeColor: 'blue',
  });
  var bounds = new google.maps.LatLngBounds();
  for (var i = 0; i < polyline.getPath().getLength(); i++) {
    bounds.extend(polyline.getPath().getAt(i));
  }
  map.fitBounds(bounds);


   // Array of markers
      var markers = [
        {
          coords:{lat:10.7667964,lng:106.6519856},
          iconImage:'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png',
          content:'<h1>Lynn MA</h1>',
        },
        {
          coords:{lat:10.7790364,lng:106.6805457},
          iconImage:'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png',
          content:'<h1>Amesbury MA</h1>',
        },

      ];

      // Loop through markers
      for(var i = 0;i < markers.length;i++){
        // Add marker
        addMarker(markers[i]);
        console.log('wtf');
      }
      // console.log('flsdjfklsd');
      // console.log(markers);
       // Add Marker Function
      function addMarker(props){
        var marker = new google.maps.Marker({
          position:props.coords,
          map:map,
          icon:props.iconImage
        });

        // Check for customicon
        if(props.iconImage){
          // Set icon image
          marker.setIcon(props.iconImage);
        }

        // Check content
        if(props.content){
          var infoWindow = new google.maps.InfoWindow({
            content:props.content
          });

          marker.addListener('click', function(){
            infoWindow.open(map, marker);
          });
        }
      }
}


initialize();

//google.maps.event.addDomListener(window, "load", initialize);

      }


    </script>


</body>

</html>
