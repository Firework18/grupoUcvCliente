(function ($) {
    "use strict";
    
    // Dropdown on mouse hover
    $(document).ready(function () {
        function toggleNavbarMethod() {
            if ($(window).width() > 992) {
                $('.navbar .dropdown').on('mouseover', function () {
                    $('.dropdown-toggle', this).trigger('click');
                }).on('mouseout', function () {
                    $('.dropdown-toggle', this).trigger('click').blur();
                });
            } else {
                $('.navbar .dropdown').off('mouseover').off('mouseout');
            }
        }
        toggleNavbarMethod();
        $(window).resize(toggleNavbarMethod);
    });
    
    
    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


    // Portfolio isotope and filter
    var portfolioIsotope = $('.portfolio-container').isotope({
        itemSelector: '.portfolio-item',
        layoutMode: 'fitRows'
    });

    $('#portfolio-flters li').on('click', function () {
        $("#portfolio-flters li").removeClass('active');
        $(this).addClass('active');

        portfolioIsotope.isotope({filter: $(this).data('filter')});
    });


    // Post carousel
    $(".post-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1500,
        dots: false,
        loop: true,
        nav : true,
        navText : [
            '<i class="fa fa-angle-left" aria-hidden="true"></i>',
            '<i class="fa fa-angle-right" aria-hidden="true"></i>'
        ],
        responsive: {
            0:{
                items:1
            },
            576:{
                items:1
            },
            768:{
                items:2
            },
            992:{
                items:2
            }
        }
    });


    // Testimonials carousel
    $(".testimonial-carousel").owlCarousel({
        center: true,
        autoplay: true,
        smartSpeed: 2000,
        dots: true,
        loop: true,
        responsive: {
            0:{
                items:1
            },
            576:{
                items:1
            },
            768:{
                items:2
            },
            992:{
                items:3
            }
        }
    });
    
})(jQuery);

const inputs = document.querySelectorAll(".input");


function addcl(){
	let parent = this.parentNode.parentNode;
	parent.classList.add("focus");
}

function remcl(){
	let parent = this.parentNode.parentNode;
	if(this.value == ""){
		parent.classList.remove("focus");
	}
}


inputs.forEach(input => {
	input.addEventListener("focus", addcl);
	input.addEventListener("blur", remcl);
});

document.addEventListener('DOMContentLoaded', function() {
    function mostrarImagen(nombreImagen) {
        console.log('hola');
        const imagen = document.createElement('IMG');
        imagen.src = `./imagenes/${nombreImagen}`;
        imagen.alt = 'Imagen Galería';
        
        console.log('Imagen: '+imagen.src);


        const modal = document.createElement('DIV');
        modal.classList.add('modal1');
        modal.onclick = cerrarModal;

        const cerrarModalBtn = document.createElement('BUTTON');
        cerrarModalBtn.textContent = 'X';
        cerrarModalBtn.classList.add('btn-cerrar');
        cerrarModalBtn.onclick = cerrarModal;

        modal.appendChild(imagen);
        modal.appendChild(cerrarModalBtn);

        document.body.classList.add('overflow-hidden');
        document.body.appendChild(modal);
    }

    function cerrarModal() {
        const modal = document.querySelector('.modal1');
        if (modal) {
            modal.classList.add('fade-out');
            setTimeout(() => {
                modal.remove();
                document.body.classList.remove('overflow-hidden');
            }, 500);
        }
    }

    const imagenes = document.querySelectorAll('[data-id]');
    imagenes.forEach(imagen => {
        imagen.addEventListener('click', function() {
            const nombreImagen = this.getAttribute('data-id');
            mostrarImagen(nombreImagen);
        });
    });
});

