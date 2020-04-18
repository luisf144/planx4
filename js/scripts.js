$(document).ready(function(){
  
    function loadUsersOnline(){
        $.get("includes/functions.php?onlineusers=result", function(data){
            $(".users-online").text(data);
        })
    };
    
    loadUsersOnline();
    
    setInterval(function(){
        loadUsersOnline();
    }, 1000);

});

