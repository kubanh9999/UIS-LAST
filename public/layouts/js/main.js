window.onscroll = function () {
    let topBarHide = document.getElementById('topBar');
    if (window.scrollY) {
        topBarHide.classList.add('hidden');
    } else {
        topBarHide.classList.remove('hidden')
    }
}

function changeImage(imageUrl) {
    document.getElementById('main-image').src = imageUrl;
}

function increaseQuantity() {
    let quantityInput = document.getElementById('quantity');
    let currentValue = parseInt(quantityInput.value);
    quantityInput.value = currentValue + 1
}

function decreaseQuantity() {
    let quantityInput = document.getElementById('quantity');
    let currentValue = parseInt(quantityInput.value);
    if (currentValue > 1) {
        quantityInput.value = currentValue - 1
    }
}

/* Stick slider */
$(document).ready(function () {
    $('.services').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        arrows: false,
        infinite: false,
        dots: false,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    arrows: false,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    arrows: false,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    arrows: false,
                    dots: false
                }
            }
        ]
    });
});
$(document).ready(function () {
    $('.recommended').slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        arrows: true,
        prevArrow: $('#prev-justforyou'),
        nextArrow: $('#next-justforyou'),
        infinite: false,
        dots: false,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    arrows: true,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    arrows: true,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    arrows: true,
                    dots: false
                }
            }
        ]
    });
});
$(document).ready(function () {
    $('.related-stick').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        arrows: true,
        prevArrow: $('#prev-justforyou'),
        nextArrow: $('#next-justforyou'),
        infinite: false,
        dots: false,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    arrows: true,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    arrows: true,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    arrows: true,
                    dots: false
                }
            }
        ]
    });
});

$(document).ready(function () {
    $('.gift-basket-home').slick({
        slidesToShow: 6,
        slidesToScroll: 1,
        arrows: false,
        infinite: false,
        dots: false,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    arrows: false,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    arrows: false,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    arrows: false,
                    dots: false
                }
            }
        ]
    });
});