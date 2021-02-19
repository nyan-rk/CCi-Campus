// Building the caroussel
document.addEventListener( 'DOMContentLoaded', function () {
    var spl=new Splide( '.splide', {
    type   : 'loop',
    width: '710px',
    perPage: 1,
    perMove: 1,
    fixedWidth: '200px',
    autoHeight:true,
    clones:0,
    gap:'20px',
    focus: 'center',
    arrows:false,
    } ).mount();
} );

$(document).ready(function(){
    //Getting the real session value that won't risk to be modified on the client side
    var realuser=user;
    //Fixing Splide's bug with Height and fixedHeight
    $('#caroussel').height('440px');
    //$('.gum-car-cardly.is-active').css({"transition":"all 0.7s linear"});
    //alert("ça marche");

    function gumRecolor(){
        var gums= $('.gum-cardly');
        for (var i = 0; i < gums.length; i++) {
        // Using $() to re-wrap the element.
            $(gums[i]).removeClass (function (index, css) {
                return (css.match (/(^|\s)gumcolor\S+/g) || []).join(' ');
            });
            gums[i].classList.add("gumcolor"+(i%5+1));
        }
    }

    $("#newProjectCreate").on("click",function(){
        teamId=$('#teamList').val();
        teamSelect='#team-'+teamId;
        console.log(teamSelect);
        projectName=$('#projectname').val();
        console.log($(teamSelect).find('.gum-cardly').length);
        if(projectName.length>0){
            $.ajax({
                url: './controller/dashboardInteract.php',
                type: 'post',
                data: {mode: 1, user:realuser, name:$('#projectname').val(), desc:$('#projectdesc').val(), team:teamId},
                success: function(data){
                    if($(teamSelect).find('.gum-cardly').length==0){
                        $(teamSelect).empty();
                    }
                    $(teamSelect).append("<a href='./diag.php?d="+data+"'><div id='"+data+"' class='gum-cardly'><div class='gum-cardly1'><img draggable='false' src='./upload/diagmin/0.jpg' ></div><div class='gum-cardly2'>"+$('#projectdesc').val()+"</div></div></a>");
                    gumRecolor();
                  console.log('Project created');
                },
                error: function(data){
                  console.log('Project not created');
                }
              });
            $('#newProjectModal').modal('toggle');
        }
    });
})