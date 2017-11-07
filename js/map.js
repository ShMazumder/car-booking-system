var addressTab = [];
var i;

function init_map() {
  var location = new google.maps.LatLng(50.057249,19.9653864);
  var geocoder = new google.maps.Geocoder();
  var map;

  $.ajax({
      url: "adminPanel/getData.php",
      data: { action: "localizations"},
      type: "POST",
      success: function (data) {
          addressTab = JSON.parse(data);
          if (geocoder) {
            for(i = 0; i < addressTab.length; i++){
              geocoder.geocode({'address': (addressTab[i].address + ", " + addressTab[i].city)}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                  if (status != google.maps.GeocoderStatus.ZERO_RESULTS) {
                    map.setCenter(results[0].geometry.location);
                    var marker = new google.maps.Marker({
                      position: results[0].geometry.location,
                      map: map
                    });

                  } else {
                    alert("No results found");
                  }
                } else {
                  alert("Geocode was not successful for the following reason: " + status);
                }
              });
            }
          }
      },
      error: function (xhr, status, error) {
          console.log('Error: ' + error.message);
      },
  });

  var mapoptions = {
    center: location,
    zoom: 12
  };

  map = new google.maps.Map(document.getElementById("map-container"), mapoptions);
}

google.maps.event.addDomListener(window, 'load', init_map);
