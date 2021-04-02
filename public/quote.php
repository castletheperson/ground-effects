<!DOCTYPE html>

<html lang="en">

  <head>

    <?php include('inc/head.inc'); ?>

    <link rel="stylesheet" href="css/quote.css" type="text/css" />

    <title>Get A Quote - Ground Effects</title>

  </head>

  <body>

    

    <header id="top">

      <?php include('inc/nav.inc'); ?>

    </header>

    

    <section id="quote">

      <div class="container">

        <div class="row">

          <div class="col-md-8">

            <h6>Get A</h6>

            <h2>Quote</h2>

            <hr />

            <form id="quote-form" action="/submit-quote" method="post">

              <div class="form-group">

                <label for="name">Name</label>

                <input id="name" name="name" type="text" class="form-control" placeholder="Enter first and last name" required />

              </div>

              <div class="form-group">

                <label for="email">Email</label>

                <input id="email" name="email" type="email" class="form-control" placeholder="Enter email" required />

              </div>

              <div class="form-group">

                <label for="phone">Phone</label>

                <input id="phone" name="phone" type="tel" class="form-control" placeholder="Enter phone number" required />

              </div>

              <div class="form-group">

                <label for="description">Description</label>

                <textarea id="description" name="description" class="form-control" placeholder="Describe your project" rows="4" required></textarea>

              </div>

              <!--<div class="form-group">

                <div class="g-recaptcha" data-theme="dark" data-sitekey="6Le__dUZAAAAACzfGjLvf73EH7nwGcgSzzyck5UM"></div>

              </div>-->

              <div class="text-center">

                <script src="https://www.google.com/recaptcha/api.js"></script>

                <script>
                  function onSubmit(token) {
                    console.log("Token", token);
                    document.getElementById("quote-form").submit();
                  }
                </script>

                <button class="g-recaptcha button center-block"
                  data-sitekey="6Lc9locaAAAAAEpsIuy2cY31z8YU1KCy6LNu-lJT"
                  data-callback='onSubmit'
                  data-action='submit'>Submit</button>

              </div>

            </form>

          </div>

          <div class="col-md-4">

            <h6>Contact</h6>

            <h2>Me</h2>

            <hr />

            <p>Tyler Burns<br />2587 Forest Hills Blvd.<br />Bella Vista, AR 72715<br /><i>(By appointment only)</i></p>

            <p>Hours of Operation:<br />8 a.m.-6 p.m. Monday-Saturday</p>

            <p><a href="mailto:geffects@yahoo.com">geffects@yahoo.com</a><br /><a href="tel:1-479-633-8985">(479) 633-8985</a><br /><a href="tel:1-479-855-5819">(479) 855-5819</a></p>

            <div id="map"></div>

          </div>

        </div>

      </div>

    </section>

    

    <?php include('inc/footer.inc'); ?>

    

    <!-- Google Map -->

    <script>

      function initMap() {

        var shop = {lat: 36.445603, lng: -94.299035};

        var map = new google.maps.Map(document.getElementById('map'), {

          zoom: 10,

          center: shop,

          disableDefaultUI: true

        });

        new google.maps.Marker({

            position: shop,

            map: map,

            icon: {

                url: "https://static.squarespace.com/universal/images-v6/icons/icon-map-marker-2x.png",

                size: new google.maps.Size(52, 68),

                scaledSize: new google.maps.Size(26, 34),

                anchor: new google.maps.Point(13, 34)

            }

        });

        map.mapTypes.set('Grayscale', new google.maps.StyledMapType([

    {

        "stylers": [

            {

                "visibility": "on"

            },

            {

                "saturation": -100

            },

            {

                "gamma": 0.54

            }

        ]

    },

    {

        "featureType": "road",

        "elementType": "labels.icon",

        "stylers": [

            {

                "visibility": "off"

            }

        ]

    },

    {

        "featureType": "water",

        "stylers": [

            {

                "color": "#4d4946"

            }

        ]

    },

    {

        "featureType": "poi",

        "elementType": "labels.icon",

        "stylers": [

            {

                "visibility": "off"

            }

        ]

    },

    {

        "featureType": "poi",

        "elementType": "labels.text",

        "stylers": [

            {

                "visibility": "simplified"

            }

        ]

    },

    {

        "featureType": "road",

        "elementType": "geometry.fill",

        "stylers": [

            {

                "color": "#ffffff"

            }

        ]

    },

    {

        "featureType": "road.local",

        "elementType": "labels.text",

        "stylers": [

            {

                "visibility": "simplified"

            }

        ]

    },

    {

        "featureType": "water",

        "elementType": "labels.text.fill",

        "stylers": [

            {

                "color": "#ffffff"

            }

        ]

    },

    {

        "featureType": "transit.line",

        "elementType": "geometry",

        "stylers": [

            {

                "gamma": 0.48

            }

        ]

    },

    {

        "featureType": "transit.station",

        "elementType": "labels.icon",

        "stylers": [

            {

                "visibility": "off"

            }

        ]

    },

    {

        "featureType": "road",

        "elementType": "geometry.stroke",

        "stylers": [

            {

                "gamma": 7.18

            }

        ]

    }

], { name: 'Grayscale' }));

        map.setMapTypeId('Grayscale');

      }

    </script>

    <script async defer

    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCSeiWk2Sx6BcP6Y3bpLeqrk5GbNpPGvQM&callback=initMap">

    </script>

  </body>

</html>