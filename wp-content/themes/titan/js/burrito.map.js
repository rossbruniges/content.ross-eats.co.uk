var ross_eats = window.ross_eats || {};

ross_eats.burritos = function() {
    var map, data_src, vcards = [], you, APP_ID = "H28tro7e",
        createMap = function(container) {
            map = new google.maps.Map(container, {
                zoom: 12,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                mapTypeControl: false
            });
            
            var success = function(position) {
                you = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
                var marker = new google.maps.Marker({
                        map:map,
                        position: you,
                        title: "You are here"
                    });
                                        
                map.setCenter(you);
                
            },
            error = function(message) {
                map.setCenter(new google.maps.LatLng(51.498798, -0.12799));
            };        
                        
            data_src.trigger('map-loaded'); 

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(success, error);
            }
            
        },
        plotData = function() {
                    
            var choose_icon = function(n) {
                    if (n === 1) {
                        return 'wp-content/themes/titan/images/map/numero_uno.png';
                    }
                    if (n <= 5) {
                        return 'wp-content/themes/titan/images/map/green' + n + '.png';
                        
                    }
                    if (n <= 9) {
                        return 'wp-content/themes/titan/images/map/orange' + n + '.png';
                    }
                    return 'wp-content/themes/titan/images/map/red' + n + '.png';
                };
            $.each(vcards, function() {
                var current = this,
                    marker = new google.maps.Marker({
                        map: map,
                        position: current.geo,
                        icon: choose_icon(current.position),
                        title: current.name 
                    });
                if (current.position === 1) {
                    /*
                    $.getJSON("google-directions.php", {
                        sensor: 'true',
                        origin: you.toString(),
                        destination: current.adr,
                        mode : "walking"
                    }, function(data) {
                        console.log(data.routes[0].legs[0].steps);
                    });
                    */
                    var directionsService = new google.maps.DirectionsService(),
                        directionsDisplay = new google.maps.DirectionsRenderer({
                            suppressMarkers: true
                        }),
                        request = {
                            origin: you, 
                            destination: current.geo,
                            travelMode: google.maps.DirectionsTravelMode['WALKING']
                        };
                        
                    directionsDisplay.setMap(map);
                    
                    directionsService.route(request, function(response, status) {
                        if (status == google.maps.DirectionsStatus.OK) {
                            console.log(response);
                          directionsDisplay.setDirections(response);
                        }
                      });
                }
            });  
        },
        extractData = function() {
                        
            var els = data_src.find('li.vcard'),
                geocoder = new google.maps.Geocoder();
            els.each(function(i) {
                                
                var current = $(this),
                    tmp = {
                        name : current.find('h3.fn').text(),
                        adr : current.find('p.adr').text(),
                        position: i + 1
                    };
                    
                geocoder.geocode( { 'address': tmp.adr }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        tmp.geo = results[0].geometry.location;
                        current.trigger('geocode_complete');
                    }
                });
                
                current.bind('geocode_complete', function() {
                    vcards.push(tmp);
                    if (vcards.length === els.length) {
                        plotData();
                    }
                });                                                        
                           
            });
        },
        init = function() {
            var c = $('#burrito-map').css({
                "width": "600px",
                "height": "400px"
            }); 
        
            if (!c.length) { return false; }
            
            data_src = $('ol.quest_list');
            
            data_src.bind('map-loaded', function() {
                extractData();
            });
                    
            createMap(c[0]);
    };
    
    return {
        init: init
    };
}();

$(function() {
    ross_eats.burritos.init();
});