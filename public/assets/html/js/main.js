function popupCenter(url, title, w, h) {
    // Fixes dual-screen position                         Most browsers      Firefox
    var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : window.screenX;
    var dualScreenTop = window.screenTop != undefined ? window.screenTop : window.screenY;

    var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
    var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

    var left = ((width / 2) - (w / 2)) + dualScreenLeft;
    var top = ((height / 2) - (h / 2)) + dualScreenTop;
    var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

    // Puts focus on the newWindow
    if (window.focus) {
        newWindow.focus();
    }
}

function drawImageScaled(img, ctx) {
    var width = parseInt(img.naturalWidth),
        height = parseInt(img.naturalHeight);

    if (width > height) {
        // landscape
    }
    else if (height > width) {
        // portrait
    }
    else {
        // square
    }

    var newCanvasWidth = 500;
    var newCanvasPer = 0;
    var newCanvasHeight = 0;

    if (newCanvasWidth < width) {
        newCanvasPer = parseInt(parseInt(width) / parseInt(newCanvasWidth));
        newCanvasHeight = parseInt(parseInt(height) / parseInt(newCanvasPer));
    }
    else {
        newCanvasWidth = width;
        newCanvasHeight = height;
    }

    var canvas = ctx.canvas;
    canvas.width = newCanvasWidth;
    canvas.height = newCanvasHeight;

    ctx.clearRect(0,0,canvas.width, canvas.height);
    ctx.drawImage(img, 0,0, canvas.width, canvas.height);

    imageHelp = canvas.toDataURL("image/jpeg");

}

function scroll_to_div(div_id)
{
    $('html,body').animate(
    {
        scrollTop: $("#"+div_id).offset().top
    },
    'slow');
}

$(function() {
    $( function() {
        $( "#register_date" ).datepicker();
        $( "#profile_date" ).datepicker();
    } );

    $('.share-social').click(function(e) {
        e.preventDefault();
        var href = $(this).attr('href');
        popupCenter(href, "Share Social", 400, 300);
        var id = $(this).data('id');
        if (id) {
            var url = baseUrl+'/gallery/share-count'
            var data = {id: id};
            $.ajax({
                url: url,
                data: data,
                type: 'post',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
        }
    })
    // $('#modalFinish').modal();


    $('#loginForgot').on('show.bs.modal', function (event) {
        $('#loginPopup').modal('hide');
    });

    $('#loginForgotChange').on('show.bs.modal', function (event) {
        $('#loginProfile').modal('hide');
    });

    $('#editProfile').on('show.bs.modal', function (event) {
        $('#loginProfile').modal('hide');
    });
    $('#register').on('show.bs.modal', function (event) {
        $('#loginPopup').modal('hide');
    });


    var $hamburger = $(".hamburger");
    $hamburger.on("click", function(e) {
        $hamburger.toggleClass("is-active");
        $('#navbarKTO').toggleClass('active');
        // Do something else, like open/close menu
    });

    jQuery(document).ready(function($) {
        $('a[data-rel^=lightcase]').lightcase();
    });

    //smooth scroll
    var $root = $('html, body');

    $('a[href^="#"]:not(.show-detail):not(.nav-link):not([data-rel^=lightcase])').click(function () {
        var target = $.attr(this, 'href');

        if( $(target).length ) {
            if(target == '#section_riddle_mobile') {
                $('#collapseFour').addClass('show');
            }

            $root.animate({
                scrollTop: $( target ).offset().top
            }, 1000);
        } else {
            $root.animate({
                scrollTop: $('[name="' + target.substr(1) + '"]').offset().top
            }, 1000);
        }

        return false;
    });

    $('.video-carousel').owlCarousel({
        loop:false,
        margin:10,
        nav: true,
        navText: ["<span><</span>","<span>></span>"],
        dots:false,
        autoWidth:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:5
            }
        }
    });

    $('.template-carousel').owlCarousel({
        loop:false,
        margin:10,
        dots:false,
        nav: true,
        navText: ["<span><</span>","<span>></span>"],
        responsive:{
            0:{
                items:1,
                margin:10,
            },
            600:{
                items:3,
                margin:30,
            },
        }
    });

    $('.form-control-file').on('change', function(e) {
        $('.img-thumb').hide();
        var reader = new FileReader();
        var canvas_id = $(this).data('canvas');
        var canvas = document.getElementById(canvas_id);
        $('#'+canvas_id).show();

        var ctx= canvas.getContext('2d');

        reader.onload = function (e) {
            var userPhoto = e.target.result;

            var mimeType = userPhoto.split(",")[0].split(":")[1].split(";")[0];
            if(mimeType.indexOf('jpeg') === -1 && mimeType.indexOf('jpg') === -1 && mimeType.indexOf('png') === -1) {
                console.log('asasas');
                ons.notification.alert('Harus Gambar JPG, JPEG atau PNG');
            } else {
                try {
                    var img = new Image();
                    img.onload= drawImageScaled.bind(null, img, ctx);
                    img.src = userPhoto;
                    console.log(img);
                }
                catch (e) {
                    console.log(e);
                }
            }
        };

        var fil = this.files[0];
        if (typeof fil !== 'undefined') {
            reader.readAsDataURL(fil);
        }
    });

});

