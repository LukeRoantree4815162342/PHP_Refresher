var bridge = function (presenterPath) {
    window.rhubarb.viewBridgeClasses.ViewBridge.apply(this, arguments);
};

bridge.prototype = new window.rhubarb.viewBridgeClasses.ViewBridge();
bridge.prototype.constructor = bridge;

bridge.prototype.attachEvents = function () {

    function Overlay(position, content, width, height, shadowImg, shadowHeight) {
        google.maps.OverlayView.apply(this, arguments);
        this.position = position;
        this.content = content;
        this.width = width || 260;
        this.height = height || 260;
        this.shadowImg = shadowImg || '';
        this.shadowHeight = shadowHeight || 100;
        this.loaded = false;
    }

    Overlay.prototype = new google.maps.OverlayView();
    Overlay.prototype.constructor = Overlay;

    Overlay.prototype.onAdd = function () {
        this.container = document.createElement('DIV');
        this.container.className = 'gmap-bubble';
        this.getPanes().floatPane.appendChild(this.container);
        this.container.style.position = 'absolute';
        this.container.style.height = this.height;
        this.container.style.width = this.width;
        this.container.innerHTML = '<div class="overlay-loading"></div>' +
            '<div class="overlay-close"><a><img src="' + window.BaseUrl + '/static/images/close-button.png"/></a></div>' +
            '<div class="overlay-panel"></div>';

        this.contentContainer = this.container.querySelector('.overlay-panel');

        var close = function () {
            this.onRemove();
        };

        this.container.querySelector('.overlay-close > a').onmouseup = close.bind(this);
    };

    Overlay.prototype.draw = function () {
        if (!this.loaded) {
            this.contentContainer.innerHTML = this.content;
        }
        var pxPos = this.getPoint();

        if(this.container) {
            this.container.style.left = (pxPos.x - 30) + 'px';
            this.container.style.top = (pxPos.y + 14) + 'px';
        }

        if (!this.loaded) {
            this.panMap();
            this.loaded = true;
        }
    };

    Overlay.prototype.show = function () {
        this.container.style.display= 'block';
    };

    Overlay.prototype.hide = function () {
        this.container.style.display = 'none';
    };

    Overlay.prototype.onRemove = function () {
        this.contentContainer.parentNode.removeChild(this.contentContainer);
        this.contentContainer = null;
        this.container.parentNode.removeChild(this.container);
        this.container = null;
    };

    Overlay.prototype.panMap = function () {
        var point = this.getPoint();
        this.getMap().panTo(this.getProjection().fromDivPixelToLatLng(new google.maps.Point(point.x + (this.width / 2 ), point.y + ( this.height / 4))));
    };

    Overlay.prototype.getPoint = function () {
        return this.getProjection().fromLatLngToDivPixel(this.position);
    };

    var markersArray = [];
    function clearOverlays() {
        for (var i = 0; i < markersArray.length; i++ ) {
            markersArray[i].setMap(null);
        }
        markersArray.length = 0;
    }

    var welcomescreen_slides = [
        {
            id: 'slide0',
            picture: '<div class="tutorialicon">♥</div>',
            text: 'Welcome to this tutorial. In the next steps we will guide you through a manual that will teach you how to use this app.'
        },
        {
            id: 'slide1',
            picture: '<div class="tutorialicon">✲</div>',
            text: 'This is slide 2'
        },
        {
            id: 'slide2',
            picture: '<div class="tutorialicon">♫</div>',
            text: 'This is slide 3'
        },
        {
            id: 'slide3',
            picture: '<div class="tutorialicon">☆</div>',
            text: 'Thanks for reading! Enjoy this app.<br><br><a id="tutorial-close-btn" href="#">End Tutorial</a>'
        }
    ];

    var options = {
        'bgcolor': '#0da6ec',
        'fontcolor': '#fff'
    };

    var welcomescreen = new Welcomescreen(welcomescreen_slides, options);


    var slideout = new Slideout({
        'panel': document.getElementById('panel'),
        'menu': document.getElementById('menu'),
        'padding': 256,
        'tolerance': 70
    });

    var self = this;

    $('.category-filter').change(function() {

        var selected = [];
        $('.category-filter').each(function(){
            if($(this).is(':checked')) {
                selected.push($(this).data('id'))
            }
        });
        refreshMarkers(selected);
    });

    refreshMarkers([]);
    function refreshMarkers(selectedVals) {
        self.raiseServerEvent('getEvents', selectedVals, function(data) {
            clearOverlays();
            if (data.length === 0) {
                if (console.error) {
                    console.error('We have no location data');
                }
                return false;
            }
            $.each(data, function (key, value) {
                try {
                    if (value.Latitude && value.Longitude) {

                        markerUrl = value.MarkerImage;

                        var pos = new google.maps.LatLng(value.Latitude, value.Longitude);
                        var icon = new google.maps.MarkerImage(markerUrl, null, null, null, new google.maps.Size(34, 34));
                        var marker = new google.maps.Marker({
                                icon: icon,
                                position: pos,
                                map: window.map,
                                optimized: false,
                                animation:google.maps.Animation.DROP
                            }),

                            tweetImage = '',
                            tweetText = '',
                            onclick;

                        var onClick = function () {
                            var element = document.getElementsByClassName('gmap-bubble');
                            if (element.length) {
                                element[0].parentNode.removeChild(element[0]);
                            }
                            var bubble = new Overlay(pos, '<div class="popup"> <h1 onClick="showFullEvent()" style="cursor:pointer;">'+value.Name+'</h1> <div id="popHide"> <p>'+value.Description+'</p> <a href='+value.TicketLink+' class="poputButton" style="text-decoration: none">Buy Ticket</a> <br> <br> <button class="poputButton">Get Directions</button> <br> <br> <button class="close" onClick="hideFullEvent()">close</button> </div> </div>');
                            bubble.setMap(marker.getMap());
                        };

                        markersArray.push(marker);

                        google.maps.event.addListener(marker, 'click', onClick);
                    }
                }
                catch( ex )
                {
                    console.log( ex );
                }
            });
        });
    }
};

window.rhubarb.viewBridgeClasses.IndexViewBridge = bridge;