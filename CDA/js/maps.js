var gmarkers = [];
var map = null;

function initialize() {
    // create the map
    var myOptions = {
        zoom: 13,
        center: new google.maps.LatLng(56.9496, 24.1052),
        mapTypeControl: false,
        navigationControl: true,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById("map"),
        myOptions);
}

/*
 * Function to post user location every 5 seconds
 */