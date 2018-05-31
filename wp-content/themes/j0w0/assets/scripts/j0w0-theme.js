var $ = jQuery;

$(document).ready(function() {
    
    // mobile menu toggle
    $("#mobile-menu-button").click(function(){
        $("#main-menu").slideToggle();
    });
    
    // portfolio slider
    $('.slider').bxSlider({
        mode: 'fade',
        auto: true,
        adaptiveHeight: true,
        pause: 5000,
        nextSelector: '.slider-next',
        prevSelector: '.slider-prev',
        nextText: '<i class="fas fa-arrow-right"></i>',
        prevText: '<i class="fas fa-arrow-left"></i>'
    });
    
    // contact form
    $("#contact-form").validate({
        errorClass: "is-invalid",
        validClass: "is-valid",
        rules: {
            "name": {
                required: true,
                minlength: 5
            },
            "email-address": {
                required: true,
                email: true,
                minlength: 10
            },
            "message": {
                required: true,
                minlength: 25
            }
        },
        submitHandler: function(form) {
            
            var formData = $(form).serialize() + "&action=submitContactForm";
            
            $.ajax({
                url: ajax.url,
                type: "post",
                data: formData,
                beforeSend: function() {
                    $("#contact-form").hide();
                    $("#ajax-spinner").show();
                },
                success: function(data) {
                    
                    $("#ajax-spinner").hide();
                    
                    $("#form-return").html(data).fadeIn(function() {
                        setTimeout(function() {
                            $("#contact-form")[0].reset();
                            $("#contact-form").find("#name").removeClass("is-valid");
                            $("#contact-form").find("#email-address").removeClass("is-valid");
                            $("#contact-form").find("#message").removeClass("is-valid");
                            $("#form-return").hide();
                            $("#contact-form").fadeIn();
                        }, 3000);
                    });
                    
                }
            });
            
        }
    });
    
    // parallax scroll
    var parallax = document.querySelectorAll(".parallax"), speed = 0.5;
    window.onscroll = function() {
        [].slice.call(parallax).forEach(function(el) {
            var windowYOffset = window.pageYOffset,
            elBackgrounPos = "50% " + (windowYOffset * speed) + "px";
            elBackgroundColor = "rgba(0,0,0, ." + (windowYOffset * 100) + ")";
            el.style.backgroundPosition = elBackgrounPos;
            el.style.backgroundColor = elBackgroundColor;
        });
    };
    
});