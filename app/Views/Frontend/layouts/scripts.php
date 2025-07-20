
<script src="<?= base_url('assets/frontend/js/jquery-3.6.0.min.js') ?>"></script>
<script src="<?= base_url('assets/frontend/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/frontend/js/jquery.ez-plus.js') ?>"></script>
<script src="<?= base_url('assets/frontend/plugin/nice-select/jquery.nice-select.min.js') ?>"></script>
<script src="<?= base_url('assets/frontend/plugin/OwlCarousel2-2.3.4/dist/owl.carousel.min.js') ?>"></script>
<script src="<?= base_url('assets/frontend/plugin/nouislider/nouislider.min.js') ?>"></script>
<script src="<?= base_url('assets/frontend/plugin/swiper/swiper-bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/frontend/js/main.js') ?>"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="<?= base_url('assets/frontend/font/bootstrap-icons.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/plugin/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/plugin/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css') ?>">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  $(document).ready(function(){
    $('.hero-carousel').owlCarousel({
      items: 1,
      loop: true,
      autoplay: true,
      autoplayTimeout: 5000,
      autoplayHoverPause: false,
      dots: false,
      nav: false,
      animateOut: 'fadeOut'
    });
  });
</script>
<script>
$(document).ready(function(){
  $('.kategori-carousel').owlCarousel({
    items: 5,
    loop: false,
    margin: 20,
    dots: true,
    nav: false,
    responsive:{
      0:{ items: 3 },
      600:{ items: 4 },
      1000:{ items: 5 }
    }
  });
});
</script>
