$(document).ready(function(){
    $('#btn-nav-previous').click(function(){
        $(".menu-inner-box").animate({scrollLeft: "-=100px"});
    });
    
    $('#btn-nav-next').click(function(){
        $(".menu-inner-box").animate({scrollLeft: "+=100px"});
    });
});

