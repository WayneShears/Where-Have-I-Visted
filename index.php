<?php
include ('phpsqlajax_dbinfo.php');
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
 if($_SERVER['REQUEST_METHOD'] == 'POST') { 
      //Define Variables
      $name = $_POST['city2'];
      $lat = $_POST['cityLat'];
      $lng = $_POST['cityLng'];
      $type = $_POST['option'];  


       $sql = "INSERT INTO markers (name, lat, lng, type)
        VALUES ('$name', '$lat', '$lng', '$type')";
      if (mysqli_query($conn, $sql)) {
        echo "<div id='maporignal'><p style='color:#006400'>Location Added to map</p></div>";
       } else {
        echo "<div id='maporignal' style='color:#006400'>Error: " . $sql . "</div><br>" . mysqli_error($conn);
       }
    }
?>
<!DOCTYPE html >
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Where have I been</title>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
<!--Google search -->
<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places" type="text/javascript"></script>
    <script type="text/javascript">
    //<![CDATA[

    var customIcons = {
      1: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_blue.png'
      },
      2: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_red.png'
      }
    };

    function load() {
      var map = new google.maps.Map(document.getElementById("map-canvas"), {
        center: new google.maps.LatLng(52.348763, -2.460938),
        zoom: 2,
        mapTypeId: 'roadmap',
         scrollwheel: true
      });
      var infoWindow = new google.maps.InfoWindow;

      // Change this depending on the name of your PHP file
      downloadUrl("phpsqlajax_genxml.php", function(data) {
        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
        for (var i = 0; i < markers.length; i++) {
          var name = markers[i].getAttribute("name");
          var address = markers[i].getAttribute("address");
          var type = markers[i].getAttribute("type");
          var point = new google.maps.LatLng(
              parseFloat(markers[i].getAttribute("lat")),
              parseFloat(markers[i].getAttribute("lng")));
          var html = "<b>" + name + "</b> <br/> <small><a href='delete.php?id=" + address + "'>Remove Marker</a>";
          var icon = customIcons[type] || {};
          var marker = new google.maps.Marker({
            map: map,
            position: point,
            icon: icon.icon
          });
          bindInfoWindow(marker, map, infoWindow, html);
        }
      });
    }

    function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
    }

    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;

      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
        }
      };
      
      function resizeMap(map) {
    google.maps.event.trigger(map, 'resize');
    mapResized = true;
}

      request.open('GET', url, true);
      request.send(null);
    }

    function doNothing() {}

    $(window).load(function(){
initialize();
});
$(function() {
    $("#expand-map").click(function() {
        $("#map-canvas").animate({"height" : "1000000px"}, 500,function(){
        //google.maps.event.trigger(map, "bounds_changed");
            initialize();
        });
        
    });
});

  </script>

  </head>

  <body onload="load()">
   <!-- <div id="map" style="width: 600px; height: 350px"></div>-->
   <div id="map-canvas" style="width:1070px;height:300px;">test</div>
<form class="form-inline" role="form" action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post">	
		<div class="form-group">
			<label for="place">Place I</label>		
				<select class="form-control" name="option">
					<option value="1">have been to</option>
					<option value="2">would like to visit</option>
				</select>
		</div>
<div class="form-group">
      <input id="searchTextField" class="form-control" type="text" size="50" placeholder="Enter a location" autocomplete="on" runat="server" />  
      <input type="hidden" id="city2" name="city2" />
      <input type="hidden" id="cityLat" name="cityLat" />
      <input type="hidden" id="cityLng" name="cityLng" />
		</div>
		<div class="form-group">
			<input type="submit" value="Update My Map" class="btn btn-default"> 
		</div>
	</form>

<script type="text/javascript">
    function initialize() {
        var input = document.getElementById('searchTextField');
        var autocomplete = new google.maps.places.Autocomplete(input);
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var place = autocomplete.getPlace();
            document.getElementById('city2').value = place.name;
            document.getElementById('cityLat').value = place.geometry.location.lat();
            document.getElementById('cityLng').value = place.geometry.location.lng();
        });
    }
    google.maps.event.addDomListener(window, 'load', initialize); 
</script>
  </body>
  <script>
    google.maps.event.trigger(map, 'resize');
  </script>

</html>
