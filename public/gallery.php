<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include('inc/head.inc'); ?>
    <link rel="stylesheet" href="css/gallery.css" type="text/css" />
    <link rel="stylesheet" href="images/photoswipe/photoswipe.css" type="text/css" />
    <link rel="stylesheet" href="images/photoswipe/default-skin/default-skin.css" type="text/css" />
    <title>Project Gallery - Ground Effects</title>
  </head>
  <body>
    
    <header id="top">
      <?php include('inc/nav.inc'); ?>
      <div class="container">
        <div class="text-center">
          <h6>Project</h6>
          <h2>Gallery</h2>
        </div>
        <br />
      </div>
    </header>
    
    <section id="gallery">
      <div class="container">
        <div class="masonry" id="gallery-images"></div>
      </div>
    </section>
    
    <?php include('inc/footer.inc'); ?>
    
    <!-- PhotoSwipe HTML http://photoswipe.com/documentation/getting-started.html -->
    <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="pswp__bg"></div>
      <div class="pswp__scroll-wrap">
        <div class="pswp__container">
          <div class="pswp__item"></div>
          <div class="pswp__item"></div>
          <div class="pswp__item"></div>
        </div>
        <div class="pswp__ui pswp__ui--hidden">
          <div class="pswp__top-bar">
            <div class="pswp__counter"></div>
            <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
            <button class="pswp__button pswp__button--share" title="Share"></button>
            <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
            <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
            <div class="pswp__preloader">
              <div class="pswp__preloader__icn">
                <div class="pswp__preloader__cut">
                  <div class="pswp__preloader__donut"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
            <div class="pswp__share-tooltip"></div> 
          </div>
          <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"> </button>
          <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"> </button>
          <div class="pswp__caption">
            <div class="pswp__caption__center"></div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- PhotoSwipe JS -->
    <script src="images/photoswipe/photoswipe.min.js"></script>
    <script src="images/photoswipe/photoswipe-ui-default.min.js"></script>
    <script>
      $(function() {
        var $gallery = $('#gallery-images'),
            $pswp = $('.pswp'),
            galleryImages = [
          { src: 'image27.jpg', w: 2016, h: 1512 },
          { src: 'image28.jpg', w: 1512, h: 2016 },
          { src: 'image29.jpg', w: 480, h: 640 },
          { src: 'image30.jpg', w: 640, h: 480 },
          { src: 'image31.jpg', w: 640, h: 480 },
          { src: 'image32.jpg', w: 640, h: 480 },
          { src: 'image33.jpg', w: 1512, h: 2016 },
          { src: 'image34.jpg', w: 1512, h: 2016 },
          { src: 'image35.jpg', w: 2016, h: 1512 },
          { src: 'image36.jpg', w: 1512, h: 2016 },
          { src: 'image37.jpg', w: 2016, h: 1512 },
          { src: 'image38.jpg', w: 2016, h: 1512 },
          { src: 'image39.jpg', w: 2016, h: 1512 },
          { src: 'image40.jpg', w: 1280, h: 1280 },
          { src: 'image22.jpg', w: 960, h: 1280 },
          { src: 'image23.jpg', w: 1280, h: 960 },
          { src: 'image24.jpg', w: 960, h: 1280 },
          { src: 'image25.jpg', w: 1000, h: 1280 },
          { src: 'image26.jpg', w: 2016, h: 1264 },
          { src: 'image1.jpg', w: 4017, h: 2860 },
          { src: 'image2.jpg', w: 4006, h: 2814 },
          { src: 'image3.jpg', w: 3024, h: 4032 },
          { src: 'image4.jpg', w: 4032, h: 3024 },
          { src: 'image5.jpg', w: 2448, h: 3264 },
          { src: 'image6.jpg', w: 4032, h: 3024 },
          { src: 'image7.jpg', w: 4032, h: 3024 },
          { src: 'image8.jpg', w: 4032, h: 3024 },
          { src: 'image9.jpg', w: 3024, h: 4032 },
          { src: 'image10.jpg', w: 1966, h: 2621 },
          { src: 'image11.jpg', w: 1136, h: 640 },
          { src: 'image12.jpg', w: 1136, h: 640 },
          { src: 'image13.jpg', w: 1136, h: 640 },
          { src: 'image14.jpg', w: 2410, h: 1808 },
          { src: 'image15.jpg', w: 3264, h: 2448 },
          { src: 'image16.jpg', w: 3264, h: 2448 },
          { src: 'image17.jpg', w: 1860, h: 1395 },
          { src: 'image18.jpg', w: 3264, h: 2448 },
          { src: 'image19.jpg', w: 1280, h: 960 },
          { src: 'image20.jpg', w: 1280, h: 960 },
          { src: 'image21.jpg', w: 1280, h: 960 }
        ];
        
        function display() {
          var options = this;
          new PhotoSwipe($pswp[0],
                         PhotoSwipeUI_Default,
                         galleryImages,
                         options).init();
        }

        galleryImages.forEach(function(img, index) {
          var src = img.src;
          img.src = 'images/' + src;
          img.msrc = 'images/thumbnails/tn_' + src;
          
          $('<img src="' + img.msrc + '" alt="Gallery Image" />')
            .appendTo($gallery)
            .click(display.bind({ index: index }));
        });
      });
    </script>
  </body>
</html>