var map;
      function initMap() {
        window.map = new google.maps.Map(document.getElementById('map'), {
          center: {lat:54.6,lng:-6},
          zoom: 9,
          disableDefaultUI: true,
          zoomControl: true,
          fullscreenControl: false
        });
      }