$(document).ready(function() {
    $(".menu_btn").click(function(){
        $(".menu_mobile").addClass("open");
        $("body").addClass("menu_opened");
    })
    $(".close_menu").click(function(){
        $(".menu_mobile").removeClass("open");
        $("body").removeClass("menu_opened");
    })

    $(".language_select").text($(".language_list li.active[data-type='mobile-header']").text());
    $(".language_select").text($(".language_list li.active[data-type='desktop-header']").text());

    $(".language_list li").click(function(){
        var languageSelect = $(this).parents(".language").children(".language_select");
        var languageActive = $(this).text();

        $(".language_list li").removeClass("active");
        $(this).addClass("active");
        languageSelect.text(languageActive);
    });

    $('.sale_content').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 5000,
        arrow: false,
        prevArrow:'<i class="fa fa-angle-left arrow arrowL" aria-hidden="true"></i>',
        nextArrow:'<i class="fa fa-angle-right arrow arrowR" aria-hidden="true"></i>',
        // settings: "unslick",
        responsive: [
            {
                breakpoint: 992,
                settings: {
                    arrows: true,
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 767,
                settings: {
                    arrows: true,
                    slidesToShow: 1
                }
            }
        ]
    });

    $('#dg-container').gallery();

    var parent = document.getElementById("amount_digits");
    var number = parent.getAttribute('data-content');
    for(var i = 0; i <= number.length-1; i++){
        var span = document.createElement("span");
        span.innerHTML = number[i];
        parent.appendChild(span);
    }
});