var idDiag = unescape(window.location.search.replace(new RegExp("^(?:.*[&\\?]" + escape("d").replace(/[\.\+\*]/g, "\\$&") + "(?:\\=([^&]*))?)?.*$", "i"), "$1"));


function screenshot(){
  html2canvas(document.body,{width:1000, height:800, background: '#fff'}).then(function(canvas) {
   var base64URL = canvas.toDataURL('image/jpeg').replace('image/jpeg', 'image/octet-stream');
   $.ajax({
      url: './controller/screenshot.php',
      type: 'post',
      data: {image: base64URL, diag:idDiag},
      success: function(data){
         console.log('Upload successful');
      },
      error: function(data){
        console.log('Upload failed');
      }
   });
 });  
}

$(document).ready(function(){
  console.log($("#dico").attr("text1"));
  //Recolor all stacks function
  function stackRecolor(){
    $('.row .colo').each(function () {
      if($(this).is(':last-child')==false) {
        //console.log($(this).index()+1);
        $(this).removeClass (function (index, css) {
          return (css.match (/(^|\s)color\S+/g) || []).join(' ');
       });
       this.classList.add("color"+(($(this).index())%4+1));
      }
      //else console.log("dernier fils"); // "this" is the current element in the loop
    });
    //console.log("Fonction recolor appelée");
  }
  
  // Function to reapply the event to newly created tasks
  function reloadSortableTask(){
	  $( ".stack" ).sortable({
      connectWith: "#diag .stack",
      placeholder: "ui-state-highlight-row",
      start: function(e, ui) {
        $(ui.item).attr('data-previndex', ui.item.index()+1);
        /*console.log($(ui.item).attr('data-previndex'));*/
        $(ui.item).attr('data-previndcol',$(ui.item).parent().parent().parent().index()+1);
      },
      update: function( event, ui ) {
        let oldpos=$(ui.item).attr('data-previndex'); // Former index
        oldcol=$(ui.item).attr('data-previndcol'); // Former stack
			  newcol=($(ui.item).parent().parent().parent().index()+1); // New stack
		    newpos=($(ui.item).index()+1); // New index
        console.log(oldcol+' '+oldpos+''+newcol+' '+newpos);
        $.ajax({
          url: './controller/updateDiag.php',
          type: 'post',
          data: {mode: 7, oldpos:oldpos, oldcol:oldcol, newpos:newpos, newcol:newcol, diag:idDiag},
          success: function(data){
            console.log('Task moved');
          },
          error: function(data){
            console.log('Task unmoved');
          }
        });
        $(ui.item).removeAttr('data-previndex');
        $(ui.item).removeAttr('data-previndcol');
        screenshot();
	  }
    }).disableSelection();
  }
	
	// Function to reapply the event to newly created stacks
  function reloadSortableStack(){
	  $("#diag").sortable({
		  connectWith: "#diag",
		  items:".colo:not(.colnew)",
		  placeholder: "ui-state-highlight-colo",
		  start: function(e, ui) {
			$(this).attr('data-previndex', ui.item.index()+1);
    },
		  update: function( event, ui ) {
        oldposi=$(this).attr('data-previndex');
			  console.log(oldposi);
        newposi=$(ui.item).index()+1;
			  console.log(newposi);
        $.ajax({
          url: './controller/updateDiag.php',
          type: 'post',
          data: {mode: 8, oldpos:oldposi, newpos:newposi, diag:idDiag},
          success: function(data){
            console.log('Stack moved');
          },
          error: function(data){
            console.log('Stack unmoved');
          }
        });
        $(this).removeAttr('data-previndex');
			  stackRecolor();
        screenshot();
      }
		}).disableSelection();
		reloadSortableTask();
	}
	reloadSortableStack();

  //Title edit
  $(".container").on("click","#diagTitle",function(){
    $(this).replaceWith("<input id='diagTitleEdit' value='"+$(this).text()+"'></input>");
    console.log(placeholderTask);
    screenshot();
  });

  $(".container").on("keypress","#diagTitleEdit",function(e){
    console.log(e.which);
    if (e.which == '13' && this.value.length>0) {
      $(this).replaceWith("<h2 id='diagTitle'>"+this.value+"</h2>");
      $.ajax({
        url: './controller/updateDiag.php',
        type: 'post',
        data: {mode: 1, title:this.value, diag:idDiag},
        success: function(data){
          console.log('Title changed');
        },
        error: function(data){
          console.log('Title unchanged');
        }
      });
    screenshot();
    }
  });

//Desc edit
  $(".container").on("click","#descDiag",function(){
    $(this).replaceWith("<textarea id='descDiagEdit'>"+$(this).text().replace('<br/>',/\n/g)+"</textarea>");
  screenshot();
  });

  $(".container").on("keypress","#descDiagEdit",function(e){
    if (e.which == '13' && this.value.length>0) {
      $(this).replaceWith("<p id='descDiag'>"+this.value.replace(/\n/g,'<br/>')+"</p>");
      $.ajax({
        url: './controller/updateDiag.php',
        type: 'post',
        data: {mode: 2, text:this.value, diag:idDiag},
        success: function(data){
          console.log('Desc changed');
        },
        error: function(data){
          console.log('Desc unchanged');
        }
      });
    screenshot();
    }
  });

  // Menu Modals
  // Menu button - fixing Bootstrap's shit.
  $("#menubutton").on("click",function(){
    if($("#menubutton").hasClass("show")){
        $("#menubutton").attr("aria-expanded",'false');
        $("#menubutton").next().removeClass("show");
        $("#menubutton").removeClass("show");
    }
    else{
        $("#menubutton").attr("aria-expanded",'true');
        $("#menubutton").addClass("show");
        $("#menubutton").next().addClass("show");
        $("#menubutton").next().attr("data-popper-placement",'bottom-end');
        $("#menubutton").next().attr("style",'margin: 0px; position: absolute; inset: 0px auto auto 0px; transform: translate(-225px, 40px);');
    }
});
  $(document).on("click", function(event){
    if(!$(event.target).closest("#menubutton").length){
      $("#menubutton").attr("aria-expanded",'false');
      $("#menubutton").next().removeClass("show");
      $("#menubutton").removeClass("show");
    }
  });

  // Menu - Delete : Yes
  $(".container").on("click","#DeleteDiagYes",function(){
    //$('#ModalDiagDelete').modal('toggle');
    window.location.href = 'dashboard.php';
    //console.log('Ta mere');
  });


  // Task and stack closure
  $(".row").on("click",".closeTask",function(){
    let $parent=$(this).parents()[0];
    let $mode;
    let $stack;
    let $task=null;
    if($parent.classList.contains('colo')){
      $mode=6;
      $stack=$(this).parent().index()+1;
      //console.log("Stack removed " +$stack);
    }
    if($parent.classList.contains('task')){
      $mode=5;
      $task=$(this).parent().index()+1;
      $stack=$(this).parent().parent().parent().parent().index()+1
      //console.log("Task removed "+$task+" from column "+$stack);
    }
    $(this).parent().hide();
    $(this).parent().remove();
    $.ajax({
      url: './controller/updateDiag.php',
      type: 'post',
      data: {mode: $mode, task:$task, stack:$stack, diag:idDiag},
      success: function(data){
        if($mode==5)
        console.log("Task "+$task+" removed from column "+$stack);
        else {
          console.log("Stack "+$stack+" removed");
          stackRecolor();
        }
      },
      error: function(data){
        console.log('Desc unchanged');
      }
    });
    screenshot();
  });

    $(".row").on("keypress",".newTask",function(e){
      if (e.which == '13' && this.value.length>0) {
        //Construction de la tâche d'après la valeur précédente
        let newTask = document.createElement('li');
        $(newTask).addClass("list-group-item task");
        newTask.draggable="true";
        this.previousSibling.appendChild(newTask);
        let col = $(newTask).parent().parent().parent().index()+1;
        //Construction de la croix de la tâche
        let newCross=document.createElement('i');
        $(newCross).addClass("fas fa-times closeTask");
        newTask.appendChild(newCross);
        newTask.appendChild(document.createTextNode(this.value));
        //Construction du nouvel input
        let newInput=document.createElement('input');
        newInput.type='text';
        newInput.classList.add("newTask");
        this.parentNode.appendChild(newInput);
        $(newInput).attr('placeholder',$("#dico").attr("text1"));
        $.ajax({
          url: './controller/updateDiag.php',
          type: 'post',
          data: {mode: 3, text:this.value, diag:idDiag, col:col, pos:$(newTask).index()+1},
          success: function(data){
            console.log('Task added '+($(newTask).index()+1));
          },
          error: function(data){
            console.log('Task not added');
            $(newTask).remove;
          }
        });
        $(this).remove();
	      reloadSortableTask();
		    screenshot();
      }
    });

    //Button for new stack
    $(".row").on("click","#newStackButton",function(){
      $(this).replaceWith("<input type='text' class='newStack' placeholder='"+$("#dico").attr("text2")+"'></input>");
  });

    //Construction nouvelle colonne
    $(".row").on("keypress",'.newStack',function(e){
      console.log(e.which);
      if (e.which == '13' && this.value.length>0) {
        this.parentNode.classList.add("color"+(($( ".colo" ).index(this.parentNode))%4 +1));
        this.parentNode.classList.remove("colnew");
        //Construction du haut avec noteholes
        let currentCol=$(this).parent().index()+1;
        $transNewTask="<?php echo $diag['newtask']?>";
        $(this).parent().append("<svg class='noteholes' height='33px' width='288px' viewBox='109 235 32.709 32.709' preserveAspectRatio='xMinYMax meet'><path d='M394.439 266.032c-.472-5.761-.295-11.597-3.73-16.789-5.684-8.588-13.292-13.719-23.741-14.243H354.97c.128 4.531-.522 8.825 4.386 12.242 4.267 2.969 3.362 8.742-.704 12.658-3.834 3.69-8.539 3.68-12.383-.029-4.088-3.946-4.955-9.631-.648-12.649 4.878-3.419 4.313-7.671 4.351-12.221h-19.997c.079 4.338-.661 8.426 3.932 11.875 4.444 3.336 3.477 9.843-.799 13.513-3.443 2.955-9.714 2.6-12.621-.715-3.698-4.215-3.604-10.462 1.143-13.566 4.702-3.074 2.794-7.268 3.348-11.107h-19.997c-.354 4.886.076 9.166 4.325 12.876 3.428 2.993 2.221 9.688-1.296 12.475-3.637 2.881-9.564 2.584-12.761-.64-3.183-3.212-3.519-9.58.131-12.487 4.341-3.458 3.55-7.828 3.601-12.224h-18.998c-.191 4.834-.135 9.241 4.166 13.027 3.41 3.004 2.398 9.255-.887 12.096-3.58 3.095-9.356 3.08-12.718-.032-3.612-3.351-4.677-9.904-.796-12.829 4.668-3.517 4.219-7.718 4.234-12.262h-19.996c.152 4.508-.555 8.812 4.361 12.215 4.262 2.95 3.395 8.73-.625 12.629-3.718 3.606-8.708 3.621-12.409.037-3.879-3.758-4.761-9.892-.658-12.693 4.93-3.367 4.276-7.659 4.329-12.19h-19.998c.016 4.546-.333 8.656 4.23 12.268 4.404 3.486 3.105 9.839-1.4 13.399-3.67 2.897-9.371 2.238-12.534-1.448-3.488-4.068-3.302-10.083 1.364-13.11 4.722-3.062 2.778-7.272 3.341-11.109h-19.998c-.222 4.826-.195 9.191 4.479 12.715 3.164 2.385 2.023 9.455-.988 12.239-3.349 3.095-9.296 3.179-12.77.177-3.301-2.853-4.317-9.095-.896-12.103 4.306-3.786 4.372-8.19 4.176-13.028h-18.998c-.211 4.851-.105 9.25 4.188 13.046 3.414 3.019 2.37 9.278-.945 12.108-3.515 3.001-9.431 2.887-12.779-.245-3.207-3.001-4.308-9.591-.951-12.178 4.632-3.569 4.718-7.895 4.488-12.731h-19.998c.15 4.509-.623 8.889 4.382 12.199 4.034 2.668 3.444 8.777-.028 12.383-3.422 3.553-8.959 3.879-12.555.738-4.225-3.691-5.349-9.676-1.035-13.052 4.588-3.593 4.22-7.721 4.235-12.268h-12.999c-3.204 1.276-6.897.659-9.935 2.616-8.571 5.524-15.017 12.453-15.559 23.328-.233 1.678.515 3.452-.503 5.053v2c1.724.945 3.594.474 5.389.476 91.234.025 182.469.022 273.703.021 1.331 0 2.664-.02 3.995-.012 1.673.008 2.487-.816 2.354-2.449z'></path></svg><i class='fas fa-times closeTask'></i><div class='card'><div class='card-header stack-header'>"+this.value+"</div><ul class='list-group list-group-flush stack'></ul><input type='text' class='newTask' placeholder='"+$("#dico").attr("text1")+"'></div>");
        //Building the new column with the button
        $('#diag').append('<div class="colo colnew"><svg viewBox="42 40 424 424" height="100px" width="100px" id="newStackButton"><path d="M255.311 38.995c-117.193-.189-212.353 94.862-212.315 212.071.038 117.023 94.93 211.911 211.947 211.938 117.032.025 211.97-94.803 212.063-211.82.091-117.03-94.657-211.999-211.695-212.189zm-24.228 302.478c-.06-20.66-.156-41.322.014-61.98.03-3.667-.766-4.704-4.58-4.663-20.325.217-40.654.108-60.982.099-7.831-.005-10.424-2.597-10.461-10.462-.043-9.33-.091-18.661-.054-27.991.026-6.475 2.988-9.442 9.476-9.455 20.661-.037 41.323-.118 61.982.083 3.725.036 4.732-.846 4.626-4.61-.291-10.322-.1-20.658-.1-30.989 0-10.33-.035-20.661.013-30.991.03-6.495 2.974-9.457 9.44-9.492 9.497-.052 18.995-.033 28.492-.007 7.175.02 10.027 2.816 10.035 9.907.024 20.494.1 40.99-.075 61.482-.03 3.571.61 4.757 4.521 4.712 20.325-.233 40.654-.115 60.982-.105 7.876.004 10.571 2.642 10.576 10.374.006 8.83-.016 17.661-.063 26.492-.049 8.812-2.369 11.054-11.375 11.056-19.995.004-39.989.101-59.983-.09-3.646-.035-4.713.729-4.676 4.566.199 20.492.08 40.986.029 61.48-.02 7.258-2.745 10.006-9.886 10.033-9.497.037-18.995.044-28.492-.003-6.511-.034-9.439-2.935-9.459-9.446z" fill="#FFA382"></path></svg></div>');
        $.ajax({
          url: './controller/updateDiag.php',
          type: 'post',
          data: {mode: 4, text:this.value, diag:idDiag, col:currentCol},
          success: function(data){
            console.log('Stack added');
          },
          error: function(data){
            console.log('Stack not added');
          }
        });
        $(this).remove();
		    reloadSortableStack();
	    	screenshot();
      }
    });

  })