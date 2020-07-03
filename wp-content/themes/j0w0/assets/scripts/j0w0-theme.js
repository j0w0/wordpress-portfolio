const $ = jQuery;

$(document).ready(function() {
    // mobile menu toggle
    $('#mobile-menu-button').click(function() {
        $('#main-menu').slideToggle();
    });

    // portfolio slider
    $('.slider').bxSlider({
        mode: 'fade',
        auto: true,
        stopAutoOnClick: true,
        adaptiveHeight: true,
        pause: 5000,
        nextSelector: '.slider-next',
        prevSelector: '.slider-prev',
        nextText: '<i class="fas fa-arrow-right"></i>',
        prevText: '<i class="fas fa-arrow-left"></i>',
    });

    // contact form
    $('#contact-form').validate({
        errorClass: 'is-invalid',
        validClass: 'is-valid',
        rules: {
            name: {
                required: true,
                minlength: 5,
            },
            'email-address': {
                required: true,
                email: true,
                minlength: 10,
            },
            message: {
                required: true,
                minlength: 25,
            },
        },
        submitHandler(form) {
            const formData = `${$(form).serialize()}&action=submitContactForm`;

            $.ajax({
                // eslint-disable-next-line no-undef
                url: ajax.url,
                type: 'post',
                data: formData,
                beforeSend() {
                    $('#contact-form').hide();
                    $('#ajax-spinner').show();
                },
                success(data) {
                    $('#ajax-spinner').hide();

                    $('#form-return')
                        .html(data)
                        .fadeIn(function() {
                            setTimeout(function() {
                                $('#contact-form')[0].reset();
                                $('#contact-form')
                                    .find('#name')
                                    .removeClass('is-valid');
                                $('#contact-form')
                                    .find('#email-address')
                                    .removeClass('is-valid');
                                $('#contact-form')
                                    .find('#message')
                                    .removeClass('is-valid');
                                $('#form-return').hide();
                                $('#contact-form').fadeIn();
                            }, 3000);
                        });
                },
            });
        },
    });

    // parallax scroll
    const parallax = document.querySelectorAll('.parallax');
    const speed = 0.5;
    window.onscroll = function() {
        [].slice.call(parallax).forEach(function(el) {
            const windowYOffset = window.pageYOffset;
            const elBackgrounPos = `50% ${windowYOffset * speed}px`;
            const elBackgroundColor = `rgba(0,0,0, .${windowYOffset * 100})`;
            el.style.backgroundPosition = elBackgrounPos;
            el.style.backgroundColor = elBackgroundColor;
        });
    };
});
