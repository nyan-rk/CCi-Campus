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

    // Add a member to a team - plus sign
    $(".container").on("click",".fa-plus",function(){
        $('#addMemberModal').modal('toggle');
        $('#addMemberModal').val($(this).parent().next().attr('id').substring(5));
      });
    
    // Add a member to a team
    $("#addMemberModal").on("click",function(){
        team=$('#addMemberModal').val();
        memberName=$('#membername').val();
        if(memberName.length>0){
            $.ajax({
                url: './controller/dashboardInteract.php',
                type: 'post',
                data: {mode: 3, user:$('#membername').val(), team:team, name:memberName},
                success: function(data){
                    console.log('Member added');
                },
                error: function(data){
                  console.log('Member not added');
                }
              });
            $('#membername').val('');
            $('#addMemberModal').val('');
            $('#addMemberModal').modal('toggle');
        }
    });

    // Remove diags - cross sign
    $(".container").on("click",".fa-times",function(){
        $('#removeTeamModal').modal('toggle');
        $('#removeTeamModal').val($(this).parent().next().attr('id').substring(5));
      });

    // Remove diags
      $("#removeTeamButton").on("click",function(){
        team=$('#removeTeamModal').val();
        keep=$('input[name=removeChoice]:checked').val();
        $.ajax({
            url: './controller/dashboardInteract.php',
            type: 'post',
            data: {mode: 4, user:realuser, submode:keep, team:team},
            success: function(data){            
                if(keep==1){
                    $('#team-'+team).prev().remove();
                    $('#team-'+team).remove();
                }
                if(keep==2){
                    $('#team-'+team).prev().remove();
                    $('#team-0').append($('#team-'+team).children());
                }
                console.log('Team removed');
                },
                error: function(data){
                console.log('Team not removed');
            }
        });
        gumRecolor();
        $('#removeTeamModal').modal('toggle');
    });

    // Create new project button
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
                    console.log("Tableau créé : "+data)
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

    // Create new team button
    $("#newTeamCreate").on("click",function(){
        teamName=$('#newteamname').val();
        if(teamName.length>0){
            $.ajax({
                url: './controller/dashboardInteract.php',
                type: 'post',
                data: {mode: 2, user:realuser, name:teamName},
                success: function(data){
                    $('#teamTables').append("<div class='row teamheader' style='align-items: center;'><div class='cardly-teamava'></div><h3>"+$('#newteamname').val()+"</h3><i class='fas fa-plus'></i><i class='fas fa-times'></i></div><div class='row' id='team-"+data+"' style='margin-top:20px'>"+$("#dico").attr("text3")+"</div>");
                    $('#teamList').append("<option value='"+data+"'>"+$('#newteamname').val()+"</option>");
                    $('#newteamname').val('');
                    console.log('Team created');
                },
                error: function(data){
                  console.log('Team not created');
                }
              });
            $('#newTeamModal').modal('toggle');
        }
    });
})