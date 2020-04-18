$(document).ready(function(){
    var modalValue = null;
    
    $('#selectAllBoxes').click(function(){
      
        $('.checkBoxes').each(function(){
                this.checked = !this.checked;
        });
        
    });
    
    $(".btn-confirm").on("click", function(){
        $("#mi-modal").modal('show');
        modalValue = $(this).attr('data-value');
    });
    
    $("#modal-btn-confirm").on("click", function(){
        modalConfirm(true);
        $("#mi-modal").modal('hide');
    });
    
    $("#modal-btn-cancel").on("click", function(){
        modalConfirm(false);
        $("#mi-modal").modal('hide');
    });
    
    var modalConfirm = function(confirm){
     if(confirm){
          window.location.href = "posts.php?delete="+modalValue;

      }        

    };
   
    
    function loadUsersOnline(){
        $.get("../includes/functions.php?onlineusers=result", function(data){
            $(".users-online").text(data);
        })
    };
    
    loadUsersOnline();
    
    setInterval(function(){
        loadUsersOnline();
    }, 1000);
    
    
});


var div_box = "<div id='load-screen'> <div id='loading'></div> </div>";
$("body").prepend(div_box);
$("#load-screen").delay(300).fadeOut(100, function(){
    $(this).remove();
})