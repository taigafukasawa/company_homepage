function initMap() {
  // color scheme
  var styles = [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#ffdf5f"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f7f1df"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#bde6ab"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}]
  var styledMapType = new google.maps.StyledMapType(styles, {name: 'Styled'});

  // position
  var mapPosition = new google.maps.LatLng(33.5907855,130.3919891,17);
  var mapOptions = {
    mapTypeControlOptions: {mapTypeIds: ['Styled']},
    center: mapPosition,
    zoom: 16,
    disableDefaultUI: true,
    //scrollwheel: false,
    mapTypeId: 'Styled'
  };

  // generate map
  var mapArea = document.getElementById('maps');
  var map = new google.maps.Map(mapArea, mapOptions);
  map.mapTypes.set('Styled', styledMapType);

  // generate marker
  var markerOptions = {
    map: map,
    position: mapPosition,
    icon: {url: 'images/logo.png'}
  };
  var marker = new google.maps.Marker(markerOptions);

  // generate info
  infoWindow = new google.maps.InfoWindow({
    content: '<div class="map_info">福岡市中央区大名2-9-35 トウセン天神ビル9F</div>'
  });
  infoWindow.open(map, marker);
};
