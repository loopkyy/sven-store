$(document).ready(function(){
    // Initialize tooltip
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize Banner Swiper
    var swiper = new Swiper(".banner-swiper", {
        spaceBetween: 30,
        effect: "fade",
        speed: 500,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        loop: true,
    });

    // Initialize Product Slider
    $(".product-slider").owlCarousel({
        responsiveClass: true,
        autoplay: true,
        dots: false,
        responsive: {
            0: { nav: false, items: 2 },
            600: { nav: true, items: 3 },
            1000: { nav: true, items: 4 },
        }
    });

    // Initialize Blog Slider
    $(".blog-slider").owlCarousel({
        responsiveClass: true,
        loop: false,
        margin: 40,
        autoplay: false,
        responsive: {
            0: { nav: false, dots: true, items: 1 },
            600: { nav: false, dots: false, items: 2 },
            1000: { nav: true, dots: false, items: 3 },
        }
    });

    // Initialize Nice Select
    $(".nice-option, .filter-option").niceSelect();

    if ($('#product-img-zoom').length > 0) {
        ZoomActive();
    }

    function ZoomActive() {
        if ($(window).width() > 768) {
            $('#product-img-zoom').ezPlus({
                zoomType: 'inner',
                cursor: 'crosshair',
                borderSize: 0
            });
        }
    }

    // Initialize Slick Slider
    var $sliderSingle = initSlider();

    // Initialize the slider
    function initSlider() {
        var $sliderNav = $(".slider-nav");
        if ($sliderNav.length > 0) {
            var slidesToShow = 4;
            var totalItems = $sliderNav.children().length; // Use children() to count items correctly
            var $sliderSingle = $sliderNav.slick({
                slidesToShow: slidesToShow,
                slidesToScroll: 1,
                arrows: false,
                dots: false,
                focusOnSelect: true
            });

            // Show/hide navigation buttons based on item count
            if (totalItems > slidesToShow) {
                $('#prevBtn, #nextBtn').show();
            } else {
                $('#prevBtn, #nextBtn').hide();
            }

            return $sliderSingle;
        }
        return null;
    }

    // Function to get the index of the active slide
    function getActiveSlideIndex() {
        if ($sliderSingle) {
            return $sliderSingle.slick('slickCurrentSlide');
        }
        return -1;
    }

    // Function to get the image source of the active slide
    function getImageOfActiveSlide() {
        var activeSlideIndex = getActiveSlideIndex();
        if (activeSlideIndex !== -1) {
            var $activeSlide = $(".slider-nav .slick-slide[data-slick-index='" + activeSlideIndex + "']");
            var $img = $activeSlide.find('img');
            var imgSrc = $img.attr('src');
            return imgSrc;
        }
        return null;
    }

    // Function to update the active image and zoom
    function updateActiveImageAndZoom() {
        var activeImgSrc = getImageOfActiveSlide();
        if (activeImgSrc && $('#product-img-zoom').length > 0) {
            $('#product-img-zoom img').attr('src', activeImgSrc);
            $('#product-img-zoom').data('zoom-image', activeImgSrc);
            ZoomActive();
        }
    }

    // Event listener for slider change
    if ($sliderSingle) {
        $sliderSingle.on('afterChange', function (event, slick, currentSlide) {
            updateActiveImageAndZoom();
        });
    }

    // Event listeners for buttons
    $('#prevBtn').on('click', function() {
        if ($sliderSingle) {
            $sliderSingle.slick('slickPrev');
        }
    });

    $('#nextBtn').on('click', function() {
        if ($sliderSingle) {
            $sliderSingle.slick('slickNext');
        }
    });

    // Counter Increament
    $(".count-increament").click(function(e) {
        var count = $(this).parent().find("input").val();
        count++;
        $(this).parent().find("input").val(count);
    });

    // Counter Decreament
    $(".count-decreament").click(function(e) {
        var count = $(this).parent().find("input").val();
        count--;
        if (count > 0) {
            $(this).parent().find("input").val(count);
        }
    });

    // Same Shipping Address Toggle
    $('#sameShippingAddress').change(function() {
        if ($(this).is(':checked')) {
            $('.shipping-details').hide();
        } else {
            $('.shipping-details').show();
        }
    });

    // Reinitialize zoom on window resize
    $(window).resize(function() {
        if ($('#product-img-zoom').length > 0) {
            ZoomActive();
        }
    });
});
