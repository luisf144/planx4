$(document).ready(function(){
    bindLikeFuncionality();

    function loadUsersOnline(){
        $.get("includes/functions.php?onlineusers=result", function(data){
            $(".users-online").text(data);
        })
    };
    
    loadUsersOnline();
    
    setInterval(function(){
        loadUsersOnline();
    }, 10000);

});


function postLikes(instanceThis, userLikedIt){
    var postId = $(instanceThis).attr("data-id");
    var currentLiked = $(instanceThis).attr("data-likes");
    var userId = $(instanceThis).attr("data-user-id");

    $.ajax({
        url: "includes/likes.php",
        type: "post",
        data: {
            liked: userLikedIt,
            currentLiked: currentLiked,
            post_id: postId,
            user_id: userId
        },
        success: successCallBackFun
    });

    function successCallBackFun(data){
        $.get("includes/likes.php?refresh_likes=true&post_id="+postId, function(data){


            $(".like-section").remove();

            $("#content-likes").html(data);
            bindLikeFuncionality();

        });
    }
}


function bindLikeFuncionality(){
    $(".like").click(function(e){
        e.preventDefault();

        postLikes(this, "yes");
        return false;

    });

    $(".unlike").click(function(e){
        e.preventDefault();

        postLikes(this, "no");
        return false;
    });
}


