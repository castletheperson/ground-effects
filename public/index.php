<!DOCTYPE html>

<html lang="en">

  <head>

    <?php include('inc/head.inc'); ?>

    <link rel="stylesheet" href="css/home.css" type="text/css" />

    <title>Ground Effects</title>

  </head>

  <body>

    

    <header id="top" data-parallax="scroll" data-image-src="images/image27.jpg">

      <?php include('inc/nav.inc'); ?>

      <div class="container">

        <div class="jumbotron">

          <h1><span class="cap">G</span>round <span class="cap">E</span>ffects <small>Landscaping</small></h1>

        </div>

      </div>

    </header>

    

    <section id="services" class="card">

      <div class="container">

        <div class="row">

          <div class="col-md-8">

            <h6>Services</h6>

            <h2>More than 20 Years of Craftsmanship</h2>

            <img src="images/logo.png" alt="Logo" />

            <p>From small to large projects, we look forward to meeting you and understanding what you want out of your yard. We do all we can to design a beautiful, useful space for your family. As a team of experts, we come together to deliver beauty down to every detail! We love to help make your yard a place you're proud to come home too, a place you want to use, a place you don't mind bragging about... because this... is your outdoor space! Welcome home! Welcome to the Ground Effects difference! Experts in design... Experts in installation!</p>

          </div>

          <div class="col-md-3 col-md-offset-1">

            <h6>Get a</h6>

            <h2>Quote</h2>

            <p>All estimates are free and flexible according to materials and scheduling.</p>

            <a href="/quote" class="button">Request</a>

          </div>

        </div>

      </div>

    </section>

    

    <section id="image-gap" data-parallax="scroll" data-image-src="images/image28.jpg"></section>

    

    <section id="testimonials" class="card">

      <div class="container">

        <div class="row">

          <div class="col-md-7">

            <h2>Testimonials</h2>

            <blockquote>

              <p>Tyler and his crew are fabulous! Tyler provided a plan based on our ideas and he performed a miracle! He stayed within our budget and he kept us informed all along the project. He promptly returns any calls or texts, and his crew is courteous and keeps the work area clean of any debris. We have plans for phase 2 next year and Ground Effects (Tyler) will be back to complete our total project.</p>

              <cite><a href="http://www.houzz.com/viewReview/689056">cpenni1</a></cite>

            </blockquote>

            <blockquote>

              <p>The project included an outdoor kitchen, fire pit, pergola, pavers, and addition of landscaping including trees and shrubbery and plants. We found Tyler Burns to be highly professional, detail oriented, prompt, courteous, and straightforward and honest. His design based upon our inputs and bringing the project from concept to reality added great value to the project. We were enormously pleased with the results and would highly recommend Tyler Burns and Ground Effects.</p>

              <cite><a href="http://www.houzz.com/viewReview/688026">K. Keeter</a></cite>

            </blockquote>

            <blockquote>

              <p>Tyler and his crew created a masterpiece with our landscaping in downtown Bentonville. People stop all the time to ask who completed our work and we are always happy to give a recommendation.</p>

              <p>Outside of a few minor rain delays, all work was completed on time and the crew was always respectful. Tyler put a lot of ownership in the work and checked in with us daily to provide updates.</p>

              <p>We are very happy we selected Ground Effects to add the great finishing touch to our remodel home.</p>

              <cite><a href="http://www.houzz.com/viewReview/602760">J. Ratcliff</a></cite>

            </blockquote>

            <blockquote>

              <p>Ground Effects Landscaping did an amazing job transforming our property! They did it all - they installed sod, built a stone patio, cedar pergola, flower beds, custom fence, custom gas fire pit, flower and foliage beds, and most importantly did it all within agreed upon budget and on time. Their cleanup is PERFECT. They also check in after the project to ensure everything is still being enjoyed. I give Tyler Burns and Ground effects the highest recommendation.</p>

              <cite><a href="http://www.houzz.com/viewReview/660313">webuser_166599</a></cite>

            </blockquote>

          </div>

          <div class="col-md-4 col-md-offset-1">

            <h5>My Promise</h5>

            <p>To use only the best in materials: wood, stone, concrete and steel. All elements of lasting value! I provide a 1 year guarantee on all labor and plant material. I never compromise quality for time. I work at giving my clients realistic schedules that accommodate their lives. I strive for honest customer service and work that is completed to your satisfaction.</p>

            <h5>See my handy work</h5>

            <a href="/gallery" class="button">Project Gallery</a>

            <hr />

            <h2>About Me &amp; My Team</h2>

            <h5>My name is Tyler Burns.</h5>

            <p>I started Ground Effects in 1996 out of my parents' truck doing only small landscape jobs with nothing more than a pick, shovel, and a desire to create. Although I knew only the basics of landscaping then, I was passionate about creating beautiful, usable spaces for people to enjoy for years to come.</p>

            <p>Since then, we've grown in knowledge and in size. Our crews have a combined experience of over 40 years of landscape installation! We stay up to date on the latest technology in our ﬁeld through educational classes and workshops. We are certiﬁed in paver installation and are a state-licensed landscape contractor. We are large enough to take on any project size, but small enough to give our customers the personal attention they deserve. All of us enjoy what we do and it shows in our work!</p>

            <hr />

          </div>

        </div>

      </div>

    </section>

    

    <?php include('inc/footer.inc'); ?>

    

    <script src="js/parallax.min.js"></script>

    <script>

      $(function() {

        function isOverflowing($el) {

          return $el.prop('scrollWidth') > $el.width();

        }

      

        var $h1 = $('.jumbotron h1');

        var maxFontSize = parseInt($h1.css('font-size'), 10);

        $(window).resize(function() {

          for (var fontSize = maxFontSize; fontSize > 0; fontSize -= 1) {

            $h1.css('font-size', fontSize + 'px');

            if (!isOverflowing($h1)) {

              break;

            }

          }

          //alert(fontSize);

        }).resize();

      });

    </script>

  </body>

</html>