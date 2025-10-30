function getLocation(callback) {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position){
        callback(true,position.coords);
    },function(error){
        $.get("https://ipwho.is/", function(response) { callback(true,{latitude:response.latitude,longitude:response.longitude}); }, "jsonp");
    });
  } else {
    $.get("https://ipwho.is/", function(response) { callback(true,{latitude:response.latitude,longitude:response.longitude}); }, "jsonp");
  }
}