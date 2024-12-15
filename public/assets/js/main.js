(function($){
    "use-strict"

    jQuery(document).ready(function(){

        //responsive nav
        const menus = $('.mainmenu').html();
        $('.responsive-menu').append(menus);

        $(document).on('click', '.res-icon', function() {
            $('.responsive-menu').toggleClass('open-res-nav');
        });

        $(document).on('click', '.responsive-menu ul li a', function() {
            $('.responsive-menu').removeClass('open-res-nav');
        });


        $(document).bind('click', '.mainmenu ul li a', function(event) {
            var $anchor = $(this);
            var headerH = '80';
            $('html, body').stop().animate({
                scrollTop: $($anchor.attr('href')).offset().top - headerH + "px"
            }, 500, 'easeInCirc');
            event.preventDefault();
        });


        $(document).bind('click', '.responsive-menu ul li a', function(event) {
            var $anchor = $(this);
            var headerH = '100';
            $('html, body').stop().animate({
                scrollTop: $($anchor.attr('href')).offset().top - headerH + "px"
            }, 500, 'easeInCirc');
            event.preventDefault();
        });


        $('#welcome-slider').owlCarousel({
            items:1,
            loop:true,
            autoplay:true,
            autoplayTimeout:3000,
        });

        $('#project-carousel').owlCarousel({
            center: true,
            loop:true,
            margin: 30,
            autoplay:true,
            autoplayTimeout:3000,
            dots: true,
            responsive: {
                0:{
                    items:1,
                    nav: false
                },
                700:{
                    items:2,
                    nav: false
                },
                1000:{
                    items:3,
                    nav: false
                }
            }
        });

        $('#client-carousel').owlCarousel({
            loop:true,
            margin: 40,
            autoplay:true,
            autoplayTimeout:3000,
            dots: true,
            responsive: {
                0:{
                    items:2,
                    nav: false
                },
                767:{
                    items:3,
                    nav: false
                },
                1000:{
                    items:5,
                    nav: false
                }
            }
        });


    });


}(jQuery))

window.addEventListener('scroll', function(){
    const header = document.getElementById('stickyHeader');
    header.classList.toggle('sticky', window.scrollY > 40);
});
