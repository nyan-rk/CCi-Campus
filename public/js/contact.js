$(document).ready(function(){

    var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

    $("#send").on("click",function(){
        check=0;
        // Last name check
        if($("#name").val().length==0)
            $("#errorname").fadeIn();
        else {
            $("#errorname").fadeOut();
            check++;
        }

        // First name check
        if($("#firstname").val().length==0)
            $("#errorfirstname").fadeIn();
        else{
            $("#errorfirstname").fadeOut();
            check++;
        }

        // Mail check
        if($("#mail").val().length==0){
            $("#errormail1").fadeIn();
            $("#errormail2").fadeOut();
        }
        else if ($("#mail").val().match(mailformat)==null){
            $("#errormail1").fadeOut();
            $("#errormail2").fadeIn();
        }
        else{
            $("#errormail1").fadeOut();
            $("#errormail2").fadeOut();
            check++;
        }
        // Subject check
        if($("#subject").val().length==0)
            $("#errorsubject").fadeIn();
        else{
            $("#errorsubject").fadeOut();
            check++;
        }

        // Message check
        if($("#message").val().length==0)
            $("#errormessage").fadeIn();
        else{
            $("#errormessage").fadeOut();
            check++;
        }

        if(check==5){
            $.ajax({
                url: './controller/send_mail.php',
                type: 'post',
                data: {name:$("#name").val(),firstname:$("#firstname").val(),email:$("#mail").val(),subject:$("#subject").val(),message:$("#message").val()},
                success: function(data){
                    $('#messageSentModal').modal('toggle');
                },
                error: function(data){
                    $('#messageNotSentModal').modal('toggle');
                }
              });
        }
    });
})