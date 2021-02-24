$(document).ready(function(){
    $('.navbar-toggler').on('click', function(){
        if($(".navbar-collapse").hasClass("show")){
            $(".navbar-collapse").attr("aria-expanded",'false');
            $(".navbar-collapse").removeClass("show");
        }
        else{
            $(".navbar-collapse").attr("aria-expanded",'true');
            $(".navbar-collapse").addClass("show");
        }

    });

})